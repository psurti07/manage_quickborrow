<?php

namespace Modules\Payment\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Route;


class PaymentController extends Controller
{
    public function phonePayLog(Request $request)
    {
        $routeTable = Route::current()->uri();
        $status = $request->input('status');
        $mainTable = 'user_registrations';
        
        switch($routeTable){
            case 'razorpay-log':
                $table = 'razorpayentry';
                $table2 = 'cardoffer';
                $column = 'txstatus';
                $column2 = 'referenceid';
                break;
            case 'phonepe-log':
                $table = 'phonepe_entry';
                $table2 = 'cardoffer';
                $column = 'txstatus';
                $column2 = 'referenceid';
                break;
            case 'sabpaisa-log':
                $table = 'subpaisa_entry';
                $table2 = 'cardoffer';
                $column = 'txstatus';
                $column2 = 'referenceid';
                break;
            case 'cipherpay-log':
                $table = 'cipherpayentry';
                $table2 = 'cardoffer';
                $column = 'txstatus';
                $column2 = 'referenceid';
                break;
            case 'vegaah-log':
                $table = 'vegaah_entry';
                $table2 = 'cardoffer';
                $column = 'txstatus';
                $column2 = 'referenceid';
                break;
            case 'zwitch-log':
                $table = 'zwitch_entry';
                $table2 = 'cardoffer';
                $column = 'txstatus';
                $column2 = 'referenceid';
                break;
            case 'paygic-log':
                $table = 'paygic_entry';
                $table2 = 'cardoffer';
                $column = 'txstatus';
                $column2 = 'referenceid';
                break;
            case 'lyra-log':
                $table = 'lyra_entry';
                $table2 = 'cardoffer';
                $column = 'statuscode';
                $column2 = 'transactionid';
                break;
            case 'zaakpay-log':
                $table = 'zaakpay_entry';
                $table2 = 'user_registrations';
                $column = 'statuscode';
                $column2 = 'transactionid';
                break;
            case 'airpay-log':
                $table = 'airpay_entry';
                $table2 = 'cardoffer';
                $column = 'statuscode';
                $column2 = 'transactionid';
                break;
            case 'cashfree-log':
                $table = 'cashfree_entry';
                $table2 = 'cardoffer';
                $column = 'txstatus';
                $column2 = 'referenceid';
                break;
            default:
                $table = 'phonepe_entry';
                $column = 'txstatus';
                $table2 = 'cardoffer';
                $column2 = 'referenceid';
                break;
        }
        
        if ($request->ajax()) {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $query = DB::table($table);
            if($request->has('entryfor') && $request->entryfor > 0){
                $query->where('entryfor',$request->entryfor);
            }
            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereRaw('DATE(rec_date)  BETWEEN  ? AND ?', [$fromDate, $toDate]);
            };
            switch($status){
                case 1:
                    $query->whereNotNull($column)->whereIn($column, ['SUCCESS','1','PAID','PAYMENT_SUCCESS','Success','100','captured']);
                    break;
                case 2:
                    $query->whereNull($column)->orWhere($column, '');
                    break;
                default:
                    break;
            };
            $payLogData = $query->orderByDesc('id')->get();
            return datatables()->of($payLogData)
                ->addIndexColumn()
                ->addColumn('rec_date', function($row){
                    return date('d-m-Y H:i:s', strtotime($row->rec_date));
                })
                ->addColumn('fullname', function ($row) use ($mainTable,$table2) {
                    $userRes = getUserData($row->userid,($row->entryfor == 11 || $row->entryfor == 12 || $row->entryfor == 51) ? $mainTable : $table2);
                    if ($userRes) {
                        return $userRes->first_name . ' ' . $userRes->last_name;
                    }
                    return 'N/A';
                })
                ->addColumn('mobile', function ($row) use ($mainTable,$table2) {
                    $userRes = getUserData($row->userid,($row->entryfor == 11 || $row->entryfor == 12 || $row->entryfor == 51) ? $mainTable : $table2);
                    if ($userRes) {
                        return $userRes->mobile;
                    }
                    return 'N/A';
                })
                ->addColumn('email', function ($row) use ($mainTable,$table2) {
                    $userRes = getUserData($row->userid,($row->entryfor == 11 || $row->entryfor == 12 || $row->entryfor == 51) ? $mainTable : $table2);
                    if ($userRes) {
                        return $userRes->email ?? $userRes->emailid;
                    }
                    return 'N/A';
                })
                ->addColumn('entryfor', function ($row) {
                    $entryForMapping = [
                        3 => 'Great Deal Offer',
                        4 => 'Elite Offer',
                        5 => 'Ultra Saver Offer',
                        6 => 'Prime Offer',
                        7 => 'Mega Offer',
                        8 => 'Premium Offer',
                        9 => 'Star Offer',
                        10 => 'Big Offer',
                        11 => 'SelfApply',
                        12 => 'LoanAgent',
                        21 => 'Great Offer',
                        22 => 'Big Benefit Offer',
                        31 => 'Standard Offer',
                        32 => 'Silver Offer',
                        52 => 'Top Offer',
                        53 => 'Excel Offer',
                    ];

                    return $entryForMapping[$row->entryfor] ?? '-';
                })
                ->addColumn('status', function ($row) use ($column){
                    return $row->$column;
                })
                ->addColumn('txnid', function ($row) use ($column2) {
                    return $row->$column2;
                })
                ->make(true);
        }
        return view('payment::index', compact('routeTable'));
    }

}
