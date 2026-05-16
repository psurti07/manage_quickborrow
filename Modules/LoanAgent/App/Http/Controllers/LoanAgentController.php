<?php

namespace Modules\LoanAgent\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoanApplications;
use App\Models\OtpVerification;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoanAgentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $loantype = $request->input('loantype');

            $query = DB::table('user_registrations as u')
            ->select('u.*', 'l.loan_type', 'l.loan_amount')
            ->join('loan_applications as l','l.userid','=','u.id')
            ->where('u.acc_type', 2)
            ->where('u.isUser',1)
            ->where('u.isDelete', 0);
            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereRaw('DATE(u.rec_date)  BETWEEN  ? AND ?', [$fromDate, $toDate]);
            }
            if ($loantype != 0) {
                $query->where('l.loan_type', $loantype);
            }

            $data = $query->orderByDesc('u.id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->rec_date))."<br/>".date('h:i:s A', strtotime($row->rec_date));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('loan_type', function ($row) {
                    return $row->loan_type == 1 ? 'Personal Loan' : 'Business Loan';
                })
                ->addColumn('loan_amount', function ($row) {
                    return formatePriceIndia($row->loan_amount);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center;"> <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')"><i class="icon-info-alt"></i></a></li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname','loan_amount', 'action'])
                ->make(true);
        }
        return view('loanagent::index');
    }

    public function info(Request $request)
    {
        $userDetails = UserRegistration::find($request->input('infoId'));
        $sourceDetails = DB::table('source_entry')->where('user_id', $userDetails->id)->get();
        $userLoan = LoanApplications::where('userid', $request->input('infoId'))->first();
        $userOtps = OtpVerification::select('mobile', 'otp', 'rec_date')->where('mobile', $userDetails->mobile)->orderByDesc('id')->get();
        $rec['details'] = $userDetails;
        $rec['loan'] = $userLoan;
        $rec['otps'] = $userOtps;
        $rec['sourceEntry'] = $sourceDetails;
        return view('loanagent::modals.infodetails')->with($rec);
    }

    public function blockUser(Request $request)
    {
        $exists = UserRegistration::find($request->id);
        if ($exists) {
            if ($exists->isActive === 1) {
                $block = UserRegistration::where('id', $request->id)->update(['isActive' => 0]);
                if ($block) {
                    return response()->json(array('type' => 'SUCCESS', 'message' => 'User has been blocked successfully!', 'data' => ''));
                } else {
                    return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong while blocking user.', 'data' => ''));
                }
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'User is already blocked!', 'data' => ''));
            }
        }
        return response()->json(array('type' => 'ERROR', 'message' => 'Invalid action perform!', 'data' => ''));
    }

    public function dndUser(Request $request)
    {
        $exists = UserRegistration::find($request->id);
        if ($exists) {
            if ($exists->isDnd === 0) {
                $dnd = UserRegistration::where('id', $request->id)->update(['isDnd' => 1]);
                if ($dnd) {
                    return response()->json(array('type' => 'SUCCESS', 'message' => 'User has been set to DND.', 'data' => ''));
                } else {
                    return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong while set DND on user', 'data' => ''));
                }
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'User has been already set on DND.', 'data' => ''));
            }
        }
        return response()->json(array('type' => 'ERROR', 'message' => 'Invalid action perform!', 'data' => ''));
    }

    public function destroyUser(Request $request)
    {
        try {
            $exists = UserRegistration::find($request->id);
            if ($exists) {
                try {
                    DB::transaction(function () use ($request) {
                        LoanApplications::where('userid',$request->id)->update(['isDelete' => 1]);
                        UserRegistration::where('id', $request->id)->update(['isDelete' => 1]);
                    });
                    return response()->json(array('type' => 'SUCCESS', 'message' => 'Customer deleted successfully!', 'data' => ''));
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(array('type' => 'ERROR', 'message' => 'Customer deletion failed!' . $e->getMessage(), 'data' => ''));
                }
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Customer not found!', 'data' => ''));
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('type' => 'ERROR', 'message' => $e->getMessage(), 'data' => ''));
        }
    }

    public function convertCustomer(Request $request)
    {
        $inputs = $request->all();
        $request->validate([
            'regdate' => 'required',
            'cardnumber' => 'required|numeric|digits:16',
            'cardamount' => 'required|numeric|between:0,9999.99',
            'paymentid' => 'required'
        ]);
        $userDetails = userDetails($request->input('userid'));
        /* registration date and date time */
        $regdate = date('Y-m-d', strtotime($request->input('regdate')));
        $regdatetime = date('Y-m-d', strtotime($request->input('regdate'))) . " " . date('H:i:s');

        $grandtotal = $netamount = $cgstamount = $sgstamount = $igstamount = 0;
        $cardno = random_code_num(16);
        /* card number if exists*/
        if ($request->has('cardnumber')) {
            $cardno = $request->input('cardnumber');
        }
        $paymentid = 'cash_' . random_code(13);
        /* payment id if exists */
        if ($request->has('paymentid')) {
            $paymentid = $request->input('paymentid');
        }
        if ($request->has('cardamount')) {
            $netamount = $request->input('cardamount');
            if ($request->has('state') && $userDetails->state == 'Gujarat') {
                $cgstamount = $netamount * 0.09;
                $sgstamount = $netamount * 0.09;
            } else {
                $igstamount = $netamount * 0.18;
            }
            $grandtotal = $netamount + $cgstamount + $sgstamount + $igstamount;
        }
        $originalUserData = DB::table('user_registrations')
                ->where('id', $userDetails->id)
                ->first();
        $originalUserData1 = [
            'rec_date' => $originalUserData->rec_date,
            'update_date' => $originalUserData->rec_date,
            //'address' => $originalUserData->address,
            'password' => $originalUserData->password,
            'refcode' => $originalUserData->refcode,
            'process_step' => $originalUserData->process_step,
            'isUser' => $originalUserData->isUser,
        ];
        try {
            DB::transaction(function () use ($netamount, $cgstamount, $sgstamount, $igstamount, $request, $paymentid, $grandtotal, $cardno, $regdate, $regdatetime, $userDetails) {
                DB::insert(
                    'INSERT INTO membership_orders (rec_date, userid, registration_date, expiry_date, card_number, amount, paymentid) VALUES (?,?,?,?,?,?,?)',
                    [$regdatetime, $userDetails->id, $regdate, date('Y-m-d', strtotime('+1 months', strtotime($regdate))), $cardno, $grandtotal, $paymentid]
                );
                $cardId = DB::getPdo()->lastInsertId();
                DB::update('UPDATE loan_applications SET rec_date = ?, status = ?, isDelete = ? WHERE id = ?', [$regdatetime, 1, 0, $request->input('applicationid')]);
                $password = random_code_num(6);
                $passwordkey = Hash::make($password);
                $refcode = strtolower(substr(str_replace(" ", "", $userDetails->first_name . ' ' . $userDetails->last_name), 0, 3));
                $refcode .= substr($userDetails->mobile, -4);
                DB::update(
                    'UPDATE user_registrations SET rec_date = ?, update_date = ?, /* address = ?, */ password = ?, refcode = ?, process_step = ?, isUser = ? WHERE id = ?',
                    [$regdatetime, $regdatetime, /* $password, */ $passwordkey, $refcode, 5, 2, $userDetails->id]
                );
                $invoiceNo = getSiteKeyValue('newinvoiceno');
                $invfor = 1;
                $invprefix = "LA_";
                DB::insert(
                    'INSERT INTO invoices (rec_date, userid, cardid, inv_prefix, inv_number, inv_date, inv_price, inv_cgst, inv_sgst, inv_igst, inv_grandtotal) VALUES (?,?,?,?,?,?,?,?,?,?,?)',
                    [date('Y-m-d H:i:s'), $userDetails->id, $cardId, $invprefix, $invoiceNo, date('Y-m-d'), $netamount, $cgstamount, $sgstamount, $igstamount, $grandtotal]
                );
                DB::update('UPDATE site_options SET rec_date = ?, option_value = ? WHERE option_key = ?', [date('Y-m-d H:i:s'), $invoiceNo + 1, 'newinvoiceno']);
            });
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Leads convert into customer successfully!', 'data' => ''));
        } catch (\Exception $e) {
            DB::table('user_registrations')
                ->where('id', $userDetails->id)
                ->update($originalUserData1);
            return response()->json(array('type' => 'ERROR', 'message' => $e->getMessage(), 'data' => ''));
        }
    }
}
