<?php

namespace Modules\Customer\App\Http\Controllers;

use App\DataTables\CustomerDataTable;
use App\DataTables\SaApplicationsDataTable;
use App\Http\Controllers\Controller;
use App\Models\LoanApplications;
use App\Models\UserTree;
use App\Models\LoanApplicationStatus;
use App\Models\UserRegistration;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Auth\App\Models\Administrations;
use Modules\CompanyLeads\App\Models\MembershipOrder;
use Modules\Invoice\App\Models\Invoice;
use Illuminate\Support\Facades\View;
use Modules\Banks\App\Models\Banks;
use App\Models\ApplicationRemarks;

class CustomerController extends Controller
{
    public function users(CustomerDataTable $dataTable){
        return $dataTable->render('customer::index');
    }

    public function usersDetails($userId){
        $customerInfo = UserRegistration::where(['id'=>$userId,'isDelete'=>0,'isUser'=>2])->first();
        $membershipOrder = MembershipOrder::where(['userid'=>$userId,'isActive'=>1,'isDelete'=>0])->orderBy('id','desc')->get();
        $loanApp = LoanApplications::where('userid',$userId)->orderByDesc('id')->get();
        $agentList = Administrations::select('id','role','fullname','mobile')->where('isDelete',0)->where('isActive',1)->whereIn('role',[5])->get();
        $agentData = Administrations::where('id',$customerInfo->staff_id)->first();
        $sourceDetails = DB::table('source_entry')->where('user_id', $userId)->orderByDesc('id')->get();
        $lastMembershipOrder = $membershipOrder->first();
        
        $expiryDate = Carbon::parse($lastMembershipOrder->expiry_date);
        $currentDateTime = Carbon::now();
        
        $offers = DB::table('user_offers')->where('userid',$userId)->first();
        $eligibilityAmt = calEligiblity($loanApp[0]['monthly_income'], $loanApp[0]['currentemi'], (($loanApp[0]['loan_type'] == 2) ? 11.5 : 12.5), $loanApp[0]['loan_amount']);
        if(!$offers){
            $jsonData = offersBankList($loanApp[0]['monthly_income'], $loanApp[0]['user_type'], $eligibilityAmt);
            $resId = DB::table('user_offers')->insertGetId([
                'rec_date' => Carbon::now(),
                'userid' => $userId,
                'offerdata' => $jsonData
            ]);
            $offers = DB::table('user_offers')->where('id', $resId)->first();
        }
        $offers = json_decode($offers->offerdata);
        
        if ($currentDateTime->greaterThanOrEqualTo($expiryDate)) {
            if($customerInfo->acc_type == 1){
                $message = 'Dear Customer, your Self-Apply Plan has been expired. We recommend you renew your plan to again access your portal and services.';
            } elseif($customerInfo->acc_type == 2) {
                $message = 'Dear Customer, your Loan Agent Plan has been expired. We recommend you renew your plan to again access your portal, services and expert consultation without interruption.';
            } else {
                $message = 'Dear Customer, your Self-Apply Plan has been expired. We recommend you renew your plan to again access your portal and services.';
            }
        } elseif ($currentDateTime->diffInHours($expiryDate) <= 48) {
            if($customerInfo->acc_type == 1){
                $message = 'Dear Customer, your Self-Apply Plan will expire in 48 hours. We recommend you renew your plan before expiry to access your portal and services without interruption.';
            } elseif($customerInfo->acc_type == 2) {
                $message = 'Dear Customer, your Loan Agent Plan will expire in 48 hours. We recommend you renew your plan before expiry to access your portal, services and expert consultation without interruption.';
            } else {
                $message = 'Dear Customer, your Self-Apply Plan will expire in 48 hours. We recommend you renew your plan before expiry to access your portal and services without interruption.';
            }
        } else {
            $message = NULL;
        }
        
        $referrals = UserTree::where('subuserid', $userId)->pluck('refferaluserid');
        $referralUsers = UserRegistration::whereIn('id',$referrals)->select('first_name','last_name','mobile','email')->get();
        
        if($customerInfo != null){
            return view('customer::customerDetails',compact(['customerInfo','membershipOrder','loanApp','agentList','agentData','message','offers','sourceDetails','referralUsers']));
        } else {
            return response()->json(array('type'=>'ERROR','message'=>'Users not found!','data'=>''));
        }
    }

    public function usersDetailsUpdate(Request $request){

        $user = UserRegistration::findOrFail($request->input('userid'));
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            //'mobile' => 'required|numeric|digits:10|regex:/^[6-9]\d{9}$/',
            'email' => 'required|email|unique:user_registrations,email,'.$user->id,
            'dob' => 'required',
            //'pancard' => ['required', 'regex:/^[A-Z]{5}\d{4}[A-Z]$/'],
            'pincode' => 'required|digits:6',
            'state' => 'required',
            'city' => 'required',
        ]);

        $result = UserRegistration::where('id',$request->input('userid'))->update( array(
            'first_name' => trim(ucfirst($request->input('first_name'))),
            'last_name' => trim(ucfirst($request->input('last_name'))),
            //'mobile' => $request->input('mobile'),
            'email' => trim(strtolower($request->input('email'))),
            'dob' => $request->input('dob'),
            //'pancard' => trim(strtolower($request->input('email'))),
            'pincode' => $request->input('pincode'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
        ));
        if($result > 0){
            return response()->json(array('type'=>'SUCCESS','message'=>'Data updated successfully','data'=>''));
        } else {
            return response()->json(array('type'=>'ERROR','message'=>'Data already updated!','data'=>''));
        }
    }

    public function generateInvoice($userId, $cardId){
        $invoiceDetails = $this->getInvoiceDetails($cardId, $userId);
        return view('customer::modals.invoices')->with(['invoice'=>$invoiceDetails['invoices'], 'users'=>$invoiceDetails['userDetails'], 'card'=>$invoiceDetails['cardDetails']]);
//        $dompdf = new Dompdf();
//        $view = View::make('')->with();
//        $html = $view->render();
//        $dompdf->loadHtml($html);
//        $dompdf->setPaper('A4', 'portrait');
//        $dompdf->render();
//        return $dompdf->stream('preview.pdf', ['Attachment' => false]);
    }

    public function getInvoiceDetails($cardId, $userId){
        try{
            $invoiceDetails = [];
            $invoiceDetails['userDetails'] = UserRegistration::where('id',$userId)->first();
            $invoiceDetails['cardDetails'] = MembershipOrder::where('id',$cardId)->first();
            $invoiceDetails['invoices'] = Invoice::where(['cardid'=>$cardId,'userid'=>$userId])->orderByDesc('id')->first();
            return $invoiceDetails;
        } catch(\Exception $e){
            return response()->json(['type'=>'ERROR','message'=>'User details not found.','data'=>'']);
        }
    }

    public function updatePassword(Request $request){
        $user = UserRegistration::find($request->input('userid'));
        if($user!=null){
            $request->validate([
                'new_password' => 'required',
                'retype_password' => 'required|same:new_password'
            ]);
            $result = $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
            if($result){
                $sent = sendChangePasswordEmail($user->first_name.' '.$user->last_name, $user->email, $user->mobile, $request->input('new_password'));
                return response()->json(array('type' => 'SUCCESS', 'message' => 'Password updated successfully', 'data' => []));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
            }
        }
        else {
            return response()->json(array('type' => 'ERROR', 'message' => 'User not found!', 'data' => []));
        }
    }

    public function assignAgent(Request $request){
        try{
            $inputs = $request->all();
            $request->validate([
                'staffid' => 'required'
            ]);
            $result = UserRegistration::where('id',$inputs['userid'])->update(['staff_id'=>$inputs['staffid']]);
            if($result){
                return response()->json(array('type'=>'SUCCESS','message'=>'Agent assign successfully!','data'=>''));
            } else {
                return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong while assigning agent.','data'=>''));
            }
        } catch(\Exception $e){
            Log::error('Exception Error', $e->getMessage());
            return response()->json(array('type'=>'ERROR','message'=>$e->getMessage(),'data'=>''));
        }


    }

    public function deactivateAccount(Request $request){
        $user = UserRegistration::find($request->input('userid'));
        if($user){
            $updateData = array('isActive'=>$request->input('status'));
            $result = UserRegistration::where('id',$request->input('userid'))->update($updateData);
            $message = '';
            if($request->input('status') == 1){
                $message = 'Account activated successfully';
            } else {
                $message = 'Account deactivate successfully';
            }
            if($result > 0){
                return response()->json(['type'=>'SUCCESS','message'=>$message]);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
            }
        } else {
            return response()->json(['type'=>'ERROR','message'=>'Invalid user perform action!']);
        }
    }

    public function deleteAccount(Request $request){
        try{
            $userId = $request->input('userid');
            DB::transaction(function () use ($userId){
                /* user tree data remove */
                $userTree = DB::table('user_tree')->where('subuserid', $userId)->first();
                Log::info('user tree', ['userTree'=>$userTree]);
                if($userTree){
                    DB::delete('DELETE FROM user_tree where subuserid = ?', [$userId]);
                }
                /* source entry data remove */
                /*$sourceEntry = DB::table('source_entry')->where('user_id', $userId)->first();
                Log::info('source entry', ['sourceEntry'=>$sourceEntry]);
                if($sourceEntry){
                    DB::delete('DELETE FROM source_entry where user_id = ?', [$userId]);
                }*/
                /* loan applied history data remove */
                /*$appliedHistory = DB::table('loan_applied_history')->where('userid', $userId)->first();
                Log::info('applied History', ['appliedHistory'=>$appliedHistory]);
                if($appliedHistory){
                    DB::delete('DELETE FROM loan_applied_history where userid = ?', [$userId]);
                }*/
                /* documents data remove */
                /*$documents = DB::table('user_documents')->where('userid',$userId)->first();
                Log::info('documents', ['documents'=>$documents]);
                if($documents){
                    DB::delete('DELETE FROM user_documents where userid = ?', [$userId]);
                }*/
                /* payout documents data remove */
                /*$payoutDoc = DB::table('user_payout_documents')->where('userid',$userId)->first();
                Log::info('payout Doc', ['payoutDoc'=>$payoutDoc]);
                if($payoutDoc){
                    DB::delete('DELETE FROM user_payout_documents where userid = ?', [$userId]);
                }*/
                /* membership order data remove */
                $membershipOrder = DB::table('membership_orders')->where('userid',$userId)->first();
                //Log::info('membership Order', ['membershipOrder'=>$membershipOrder]);
                if($membershipOrder){
                    DB::table('membership_orders')->where('userid', $userId)->update(['isDelete'=>1]);
                }
                /* invoice data remove */
                $invoice = DB::table('invoices')->where('userid',$userId)->first();
                //Log::info('invoice', ['invoice'=>$invoice]);
                if($invoice){
                    DB::table('invoices')->where('userid', $userId)->update(['isdelete'=>1]);
                }
                /* loan applications data remove */
                $loanApplications = DB::table('loan_applications')->where('userid',$userId)->first();
                //Log::info('loan Applications', ['loanApplications'=>$loanApplications]);
                if($loanApplications){
                    DB::table('loan_applications')->where('userid', $userId)->update(['isDelete'=>1]);
                }
                /* user registration data remove */
                $userReg = DB::table('user_registrations')->where('id', $userId)->first();
                //Log::info('user registrations', ['userRegistrations'=>$userReg]);
                if($userReg){
                    DB::table('user_registrations')->where('id', $userId)->update(['isDelete'=>1]);
                }
            });
            return response()->json(array('type'=>'SUCCESS','message'=>'Customer remove successfully!'));
        } catch(\Exception $e){
            Log::error('error', ['error'=>$e->getMessage()]);
            return response()->json(array('type'=>'ERROR','message'=>'Oops! Something went wrong.'));
        }
    }
    
    public function clickCounts(Request $request){
        try{
            $counts = DB::table('click_counts')->where('user_id', $request->userId)->where('applylink_id', $request->applyId)->orderByDesc('id')->get();
            $bank = DB::table('banks')->where('id', $request->bankId)->select('bank_name','bank_image')->first();
            return view('customer::modals.clickcounts',compact('counts', 'bank'));
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
        }
    }
    
    public function downloadReport($userId, $cardId){
        try{
            $userData = UserRegistration::where('id',$userId)->select('first_name','last_name','staff_id','mobile','email','acc_type')->first();
            $agent = Administrations::where('id',$userData->staff_id)->select('fullname','mobile','emailid')->first();
            $membershipData = MembershipOrder::where('userid',$userId)->select('registration_date','expiry_date','card_number')->first();
            $offers = optional(DB::table('user_offers')->where('userid', $userId)->first())->offerdata;
            $offers = json_decode($offers);
            $remarks = DB::table('application_remarks AS ar')
                ->select('ar.*','lr.title','lr.remarks','lr.statusid','admin.fullname')
                ->join('loanstatus_remarks AS lr','lr.id','=','ar.subject')
                ->join('administrations AS admin','admin.id','=','ar.staff_id')
                ->where('application_id',$cardId)
                ->orderBy('id','DESC')->get();
            $plan = 'Self Apply Plan';
            $planCode = 11;
            $invoice = DB::table('invoices')->where('userid', $userId)->select('inv_prefix','inv_number')->first();
            return view('customer::dwreport',compact('userData','agent','membershipData','offers','remarks','plan','planCode','invoice','userId'));
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
        }
    } 
    
    
    /* apllications of self apply starts */
    public function saApplication(SaApplicationsDataTable $dataTable, $type){
        $agentList = Administrations::where('role',5)->where(['isActive'=>1,'isDelete'=>0])->get();
        return $dataTable->with('type', $type)->render('customer::saApplications',compact('agentList'));
    }
    
    public function saApplicationDetails($userId){
        try{
            $data = UserRegistration::with(['loanApplications' => function($query) use ($userId) {
                $query->where('userid', $userId);
            }])->where('id',$userId)->first();
            $agentDetails = Administrations::where('id',$data->staff_id)->where('isDelete',0)->first();
            $offers = DB::table('user_offers')->where('userid',$userId)->first();
            $eligibilityAmt = calEligiblity($data->loanApplications[0]->monthly_income, $data->loanApplications[0]->currentemi, (($data->loanApplications[0]->loan_type == 2) ? 11.5 : 12.5), $data->loanApplications[0]->loan_amount);
            if(!$offers){
                $jsonData = offersBankList($eligibilityAmt->monthly_income, $eligibilityAmt->user_type, $eligibilityAmt);
                $resId = DB::table('user_offers')->insertGetId([
                    'rec_date' => Carbon::now(),
                    'userid' => $userId,
                    'offerdata' => $jsonData
                ]);
                $offers = DB::table('user_offers')->where('id', $resId)->first();
            }
            $offers = json_decode($offers->offerdata);
            $remarks = DB::table('application_remarks AS ar')
                    ->select('ar.*','lr.title','lr.remarks','lr.statusid','admin.fullname')
                    ->join('loanstatus_remarks AS lr','lr.id','=','ar.subject')
                    ->join('administrations AS admin','admin.id','=','ar.staff_id')
                    ->where('application_id',$data->loanApplications[0]->id)
                    ->orderBy('id','DESC')->get();
            return view('customer::applicationDetails', compact('data','agentDetails','offers','remarks'));
        } catch(\Exception $e){
            Log::info('An error occured in self apply application details - '. $e->getMessage());
            dd('check log');
        }
    }
    
    public function verifiedAccount($appId){
        try{
            $appdetails = appDetailsWithUser($appId);
            $staff = optional(DB::table('administrations')->where('id',$appdetails->staff_id)->first())->mobile;
            $banklist = Banks::where(['isActive' => 1,'isDelete' => 0])->get();
            $loanRemarks = DB::table('loanstatus_remarks')->where('statusid',6)->get();
            return view('customer::addStatus',compact(['appdetails','banklist','loanRemarks','staff']));
        } catch(\Exception $e ){
            Log::info('verified acc function - '. $e->getMessage());
            return redirect(route('manage.selfapply.loan.applications.details',['userId'=>$appId->userid]));
        }
    }
    
    public function closeAccount($appId){
        try{
            $appdetails = appDetailsWithUser($appId);
            $staff = optional(DB::table('administrations')->where('id',$appdetails->staff_id)->first())->mobile;
            $banklist = Banks::where(['isActive' => 1,'isDelete' => 0])->get();
            $loanRemarks = DB::table('loanstatus_remarks')->where('statusid',11)->get();
            return view('customer::addStatus',compact(['appdetails','banklist','loanRemarks','staff']));
        } catch(\Exception $e ){
            Log::info('closed account function - '. $e->getMessage());
            return redirect(route('manage.selfapply.loan.applications.details',['userId'=>$appId->userid]));
        }
    }
    
    public function storeRemarks(Request $request){
        $inputs = $request->all();
        $validated = $request->validate([
            'subject'       => 'required|string',
            'process'       => 'required',
        ]);
        try{
            $remarkData = [
                'rec_date' => now(),
                'entry_at' => $request->entry_at,
                'subject' => $request->subject,
                'application_id' => $request->applicationid,
                'staff_id' => Auth::id(),
                'service' => (int) $request->process,
                'notes' => $request->notes
            ];
            
            $remark = ApplicationRemarks::create($remarkData);
            
            /*if ($remark) {*/
                $userUpdate = [
                    'update_date' => now(),
                    'process_step' => (int) $request->process,
                ];
    
                if ($request->has('isVerified')) {
                    $userUpdate['isVerified'] = $request->isVerified;
                }
                $updated = UserRegistration::where('id', $request->userid)->update($userUpdate);
                
                if($updated){
                    /*$data3 = array(
                        'phoneNumber' => $request->usermobile,
                        'countryCode' => '+91',
                        'event' => 'Hire_Service_Completed',
                    );
                    $restrack2 = event_track($data3);*/
                    
                    /* send remarks message starts */
                    $slug = (($request->process == 11) ? 'sales_cycle_closed' : 'verified_customer' );
                    $msg = DB::table('sms_list')->where('type',1)->where('slug',$slug)->first()->message;
                    if($msg!='#'){
                        $senderId = DB::table('info_pages')->where('slug','sa-senderid')->first()->content;
                        sendDynamicSMS($senderId, $msg, $request->usermobile, 'self');
                    }
                    /* send remarks message ends */
                    
                    return response()->json([
                        'type' => 'SUCCESS',
                        'message' => 'Remarks added successfully!',
                        'data' => $request->userid
                    ]);    
                } else {
                    Log::info('Failed to update user registration for ID: ' . $request->userid);
                    return response()->json([
                        'type' => 'ERROR',
                        'message' => 'Oops! Something went wrong while updating user.',
                        'data' => $request->userid
                    ]);
                }
            /*} else {
                return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'], 200);
            }*/
        } catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.'], 200);
        }
    }
    
    public function deleteRemarks(Request $request){
        try{
            $res = ApplicationRemarks::findOrFail($request->id);
            if($res){
                $res->delete();
                return response()->json(['type'=>'SUCCESS', 'message'=>'Remark deleted successfully']);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
            }
        } catch(\Exception $e){
            Log::info('delete remarks - '. $e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
        }
    }
    
    public function updateProcess(Request $request){
        try{
            $res = UserRegistration::findOrFail($request->id);
            if($res){
                $res->process_step = 5;
                $res->save();
                $entryExists = DB::table('application_remarks')->where('application_id', $request->appid)->first();
                if(!$entryExists){
                    DB::table('application_remarks')->insert([
                        'rec_date' => date('Y-m-d H:i:s'),
                        'entry_at' => date('Y-m-d H:i:s'),
                        'service' => 5,
                        'subject' => 9,
                        'notes' => '',
                        'application_id' => $request->appid,
                        'staff_id' => 5
                    ]);
                }
                return response()->json(['type'=>'SUCCESS', 'message'=>'User successfully move on 5th step.']);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
            }
        } catch(\Exception $e){
            Log::info('delete remarks - '. $e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
        }
    }
}
