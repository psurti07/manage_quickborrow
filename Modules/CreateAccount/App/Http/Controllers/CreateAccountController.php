<?php

namespace Modules\CreateAccount\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cardoffer;
use App\Models\LoanApplications;
use App\Models\UserRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Modules\CompanyLeads\App\Models\MembershipOrder;
use Modules\Invoice\App\Models\Invoice;
use Modules\SiteOptions\App\Models\SiteOption;

class CreateAccountController extends Controller
{
    public function index(){
        return view('createaccount::index');
    }
    
    public function postalDetails(Request $request)
    {
        try{
            $promise = getPostalDetailsByPincode($request->input('pincode'));
            return response()->json(['status' => 'success', 'district' => $promise['city'], 'state' => $promise['state'],]);    
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'district' => '', 'state' => '','message'=>'Invalid Pincode']);    
        }
    }

    /* create account process */
    public function store(Request $request)
    {
        try {
            $this->validateRequest($request);
    
            $userDetails = UserRegistration::where('mobile', $request->input('mobile'))
                ->where(['isDelete' => 0, 'isActive' => 1]);
    
            if ($userDetails->count() > 0) {
                $user = $userDetails->first();
    
                if ($user->isUser == 1) {
                    $success = $this->createAccount($request->all(), $userDetails, 'update');
                    return $this->handleResponse($success);
                }
    
                return response()->json(['type' => 'ERROR', 'message' => 'This mobile number is already registered.'], 200);
            }
    
            $success = $this->createAccount($request->all(), $userDetails, 'insert');
            return $this->handleResponse($success);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['type' => 'error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Account creation failed: ' . $e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Oops! Something went wrong.'], 500);
        }
    }
    
    /* validate fields */
    public function validateRequest($request){
        $request->validate([
            'rec_date' => 'required|date',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'mobile' => 'required|numeric|digits:10|regex:/^[6-9]\d{9}$/',
            'email' => 'required|email',
            // 'dob' => 'required|date',
            // 'pancard' => 'required|regex:/^[A-Z]{5}\d{4}[A-Z]$/|unique:user_registrations,pancard',
            'pincode' => 'required|digits:6',
            'state' => 'required|string',
            'city' => 'required|string',
            'monthly_income' => 'required|numeric|min:0',
            'currentemi' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'loan_amount' => 'required|numeric|min:0',
            'card_number' => 'required|digits:16|regex:/^\d{16}$/',
            'paymentid' => 'required|string',
            'acc_type' => 'required',
            'loan_type' => 'required',
            'user_type' => 'required',
            'loan_purpose' => 'nullable',
            'isOffer' => 'nullable',
        ], [
            'amount.required' => 'The card amount field is required.',
            'rec_date.required' => 'The registration date field is required.',
        ]);
    }
    
    /* handle response */
    protected function handleResponse($success)
    {
        return (($success) ? response()->json(['type' => 'SUCCESS', 'message' => 'Account created successfully!'], 200) : response()->json(['type' => 'ERROR', 'message' => 'Oops! Something went wrong.'], 500));
    }
    
    /* create account */
    public function createAccount($fields, $userDetails, $type)
    {
        DB::beginTransaction();
        
        try{
            $userID = $userDetails->first()->id ?? 0;

            $password = random_code(6);
            $hashPassword = Hash::make($password);
            $refCode = strtolower(substr(str_replace(" ", "", $fields['first_name']), 0, 3)) . substr($fields['mobile'], -4);
            $paymentId = $fields['paymentid'] ?? 'cash_' . random_code(13);
            $cardNo = $fields['card_number'] ?? random_code_num(16);
            
            $amount = $fields['amount'];
            $cgst = $sgst = $igst = 0;
            
            if ($fields['state'] === 'Gujarat') {
                $cgst = $amount * 0.09;
                $sgst = $amount * 0.09;
            } else {
                $igst = $amount * 0.18;
            }
            
            $grandTotal = $amount + $cgst + $sgst + $igst;
            $recDate = Carbon::parse($fields['rec_date']);
            $expiryDate = $recDate->copy()->addMonth();
            
            $invoiceNo = DB::table('invoices')->orderBy('inv_number', 'desc')->first()->inv_number + 1;
            $invPrefix = $this->getInvoicePrefix($fields['acc_type']);
            
            $staffID = $this->assignStaff($fields['acc_type']);
            $staffid = $staffID ? $staffID->id : 0;
            
            $userData = [
                'staff_id' => $staffid,
                'rec_date' => $recDate,
                'update_date' => $recDate,
                'offerpage' => (($fields['isOffer'] == 1) ? $fields['offerpage'] : 0),
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'mobile' => $fields['mobile'],
                'email' => $fields['email'],
                'password' => $hashPassword,
                'pincode' => $fields['pincode'],
                'city' => $fields['city'],
                'state' => $fields['state'],
                'process_step' => 5,
                'refcode' => $refCode,
                'acc_type' => $fields['acc_type'],
                'isUser' => 2,
                'iAgree' => 0,
            ];
            
            if ($type === 'insert') {
                $user = UserRegistration::create($userData);
                $userID = $user->id;
            } elseif ($type === 'update') {
                UserRegistration::where('id', $userID)->update($userData);
            }
    
            if (!empty($fields['isOffer'])) {
                Cardoffer::where('mobile', $fields['mobile'])->update(['user_id' => $userID, 'isCustomer'=>1]);
            }
            
            $loanData = [
                'rec_date' => $recDate,
                'userid' => $userID ?? 0,
                'loan_type' => $fields['loan_type'],
                'loan_amount' => $fields['loan_amount'],
                'user_type' => $fields['user_type'],
                'monthly_income' => $fields['monthly_income'],
                'currentemi' => $fields['currentemi'],
                'loan_purpose' => $fields['loan_purpose'],
                'application_number' => random_code(8),
            ];
            
            if ($type === 'insert') {
                $loanApp = LoanApplications::create($loanData);
                $loanId = $loanApp->id;
            } elseif ($type === 'update') {
                LoanApplications::where('userid', $userID)->update($loanData);
                $loanApp = LoanApplications::where('userid', $userID)->orderByDesc('id')->first();
                $loanId = $loanApp->id ?? 0;
            }
            
            $membership = MembershipOrder::create([
                'rec_date' => $recDate,
                'userid' => $userID ?? 0,
                'registration_date' => $recDate,
                'expiry_date' => $expiryDate,
                'card_number' => $cardNo,
                'amount' => $grandTotal,
                'paymentid' => $paymentId,
            ]);
            
            Invoice::create([
                'rec_date' => $recDate,
                'userid' => $userID,
                'cardid' => $membership->id ?? 0,
                'inv_prefix' => $invPrefix,
                'inv_number' => $invoiceNo,
                'inv_date' => $recDate->format('Y-m-d'),
                'inv_price' => $amount,
                'inv_cgst' => $cgst,
                'inv_sgst' => $sgst,
                'inv_igst' => $igst,
                'inv_grandtotal' => $grandTotal,
                'isDelete' => 0
            ]);
            
            SiteOption::where('option_key', 'newinvoiceno')->update([
                'rec_date' => now(),
                'option_value' => $invoiceNo + 1
            ]);
            
            DB::table('application_remarks')->insert([
                'rec_date' => $recDate,
                'entry_at' => $recDate,
                'service' => 5,
                'subject' => 9,
                'notes' => '',
                'application_id' => $loanId ?? 0,
                'staff_id' => 5
            ]);
            
            DB::commit();
            
            /* mail sending */
            $mailData = array(
                'fullname' => $fields['first_name']. ' ' .$fields['last_name'],
                'mobile' => $fields['mobile'],
                'email' => $fields['email'],
                'password' => $password,
                'order_number' => $invPrefix.$invoiceNo,
                'order_date' => $recDate,
                'order_amount' => $grandTotal,
                'transactionId' => $paymentId,
            );  
            
            if($fields['acc_type'] == 2 || $fields['acc_type'] == 3){
                $mailData['agentName'] = $staffID->fullname;
                $mailData['agentMobile'] = $staffID->mobile;
                $sendGreetings = view('mail.welcomeGreetingsla',$mailData)->render();
            } else {
                $sendGreetings = view('mail.welcomeGreetings',$mailData)->render();    
            }
            
            $invAttach = array_merge(
                [
                    'rec_date' => $recDate,
                    'userid' => $userID ?? 0,
                    'cardid' => $membership->id ?? 0,
                    'inv_prefix' => $invPrefix,
                    'inv_number' => $invoiceNo,
                    'inv_date' => $recDate->format('Y-m-d'),
                    'inv_price' => $amount,
                    'inv_cgst' => $cgst,
                    'inv_sgst' => $sgst,
                    'inv_igst' => $igst,
                    'inv_grandtotal' => $grandTotal,
                    'isDelete' => 0
                ],
                [
                    'fullname' => $fields['first_name']. ' ' .$fields['last_name'],
                    'city' => $fields['city'],
                    'mobile' => $fields['mobile'],
                    'email' => $fields['email'],
                    'acc_type' => $fields['acc_type'],
                    'state' => $fields['state'],
                ],
                [
                    'card_number' => $cardNo,
                    'registration_date' => $recDate,
                    'expiry_date' => $expiryDate,
                    'paymentid' => $paymentId,
                ]
            );
            
            $invoiceData = view('mail.invoice', $invAttach)->render();
            $pdf = Pdf::loadHTML($invoiceData)->setPaper('A4', 'portrait')->output();
            $base64Pdf = base64_encode($pdf);
            
            /* creating attachments array */
            $attachments = [
                [
                    'content' => $base64Pdf,
                    'name' => 'Invoice.pdf'
                ]
            ];

            $plan = (($fields['acc_type'] == 2) ? 'Loan Agent Plan' : 'Self Apply Plan');
            sendBrevoHtmlMail2($mailData, 'Congratulations! Payment Successful for QuikBorrow '.$plan, $sendGreetings, 3, $attachments);
            
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in createAccount: ' . $e->getMessage());
            return false;
        }
    }
    
    /* invoice prefix */
    public function getInvoicePrefix($accType){
        switch($accType) {
            case 2:
                $invPrefix = 'LA_';
                break;
            case 3:
                $invPrefix = 'LAT_';
                break;
            default:
                $invPrefix = 'SA_';
                break;
        }
        return $invPrefix;
    }
    
    /* assign agent data */
    public function assignStaff($accType)
    {
        switch($accType) {
            case 2: 
                $staff = assignAgent();
                break;
            default:
                $staff = assignAgentSelf();
                break;
        }
        return $staff;
    }
    
}
