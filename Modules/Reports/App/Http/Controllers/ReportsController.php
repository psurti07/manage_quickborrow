<?php

namespace Modules\Reports\App\Http\Controllers;

use App\DataTables\CompanyGSTDataTable;
use App\DataTables\UtmSourceDataTable;
use App\Http\Controllers\Controller;
use App\Models\UserRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\App\Models\Invoice;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    public function gstData(Request $request)
    {
        if ($request->ajax()) {
            $resdata = array();
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $invData = DB::table('invoices')->where('isDelete', 0)->orderByDesc('inv_date');
            if (!empty($fromDate) && !empty($toDate)) {
                $invData->whereBetween('inv_date', [$fromDate, $toDate]);
            }
            $queryRes = $invData->get();
            if (count($queryRes)) {
                foreach ($queryRes as $row) {
                    $resrow = array();
                    $resrow['fullname'] = $resrow['mobile'] = $resrow['email'] = $resrow['city'] = $resrow['state'] = $resrow['paymentid'] = $resrow['gstno'] = $resrow['aadharno'] = $resrow['panno'] = '';

                    $resrow['id'] = $row->id;
                    $resrow['inv_prefix'] = $row->inv_prefix;
                    $resrow['inv_number'] = $row->inv_number;
                    $resrow['inv_date'] = $row->inv_date;
                    $resrow['inv_price'] = $row->inv_price;
                    $resrow['inv_cgst'] = $row->inv_cgst;
                    $resrow['inv_sgst'] = $row->inv_sgst;
                    $resrow['inv_igst'] = $row->inv_igst;
                    $resrow['inv_grandtotal'] = $row->inv_grandtotal;

                    $userRes = getUserData($row->userid,'user_registrations');
                    
                    if ($userRes) {
                        $resrow['fullname'] = $userRes->first_name . ' ' . $userRes->last_name;
                        $resrow['mobile'] = $userRes->mobile;
                        $resrow['email'] = $userRes->email;
                        $resrow['city'] = $userRes->city;
                        $resrow['state'] = $userRes->state;
                        $resrow['company_name'] = $userRes->company_name;
                        $resrow['company_gst'] = $userRes->company_gst;

                        if ($row->cardid != '' && $row->cardid > 0) {
                            $orderRes = DB::table('membership_orders')->where('id', $row->cardid)->first();
                            $resrow['paymentid'] = $orderRes->paymentid ?? '';
                        }
                        $userResDoc = userPayoutDoc($row->userid);
                        if ($userResDoc) {
                            $resrow['gstno'] = $userResDoc->gstdoc_number;
                            $resrow['aadharno'] = $userResDoc->aadharcard_number;
                            $resrow['panno'] = $userResDoc->pancard_number;
                        }
                    }
                    $resdata[] = $resrow;
                }
            }
            return DataTables::of($resdata)
                ->addIndexColumn()
                ->addColumn('inv_date', function ($row) {
                    return date('Y-m-d', strtotime($row['inv_date']));
                })
                ->addColumn('inv_no', function ($row) {
                    return $row['inv_prefix'] . '' . $row['inv_number'];
                })
                ->addColumn('fullname', function ($row) {
                    return $row['fullname'];
                })
                ->addColumn('city', function ($row) {
                    return $row['city'];
                })
                ->addColumn('state', function ($row) {
                    return $row['state'];
                })
                ->rawColumns(['inv_date', 'inv_no', 'fullname', 'city', 'state'])
                ->make(true);
        }
        return view('reports::pages.gstData');
    }

    public function tdsData(Request $request)
    {
        if ($request->ajax()) {
            $resdata = array();
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $queryRes = DB::table('user_tree')->where('payout', 1)->orderByDesc('payout_date');
            if (!empty($fromDate) && !empty($toDate)) {
                $queryRes->whereBetween('payout_date', [$fromDate, $toDate]);
            }
            $queryRes = $queryRes->get();
            if (count($queryRes)) {
                foreach ($queryRes as $row) {
                    $resrow = array();
                    $resrow['gstno'] = $resrow['aadharno'] = $resrow['panno'] = '';

                    $resrow['id'] = $row->id;
                    $resrow['payout_date'] = $row->payout_date;
                    $resrow['payout_amount'] = $row->payout_amount;
                    $resrow['order_amount'] = $row->order_amount;
                    $resrow['refferaltype'] = $row->refferaltype;
                    if ($row->refferaltype == 1) {
                        $responseUser = getUserData($row->refferaluserid);
                        if ($responseUser) {
                            $resrow['fullname'] = $responseUser->first_name . ' ' . $responseUser->last_name;
                            $resrow['mobile'] = $responseUser->mobile;
                            $resrow['email'] = $responseUser->email;
                            $resrow['city'] = $responseUser->city;
                            $resrow['state'] = $responseUser->state;

                            $userResDoc = userPayoutDoc($row->refferaluserid);
                            if ($userResDoc) {
                                $resrow['gstno'] = $userResDoc->gstdoc_number;
                                $resrow['aadharno'] = $userResDoc->aadharcard_number;
                                $resrow['panno'] = $userResDoc->pancard_number;
                            }
                        }
                    }
                    $resdata[] = $resrow;
                }
            }
            return DataTables::of($resdata)
                ->addIndexColumn()
                ->rawColumns([])
                ->make(true);
        }
        return view('reports::pages.tdsData');
    }

    public function invoiceData(Request $request)
    {
        if ($request->ajax()) {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            
            $invData = DB::table('invoices')->where('isDelete', 0);
            if (!empty($fromDate) && !empty($toDate)) {
                $invData->whereRaw('DATE(inv_date)  BETWEEN  ? AND ?', [$fromDate, $toDate]);
            }
            $data = $invData->orderByDesc('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('invDate', function ($row) {
                    return date('d-m-Y', strtotime($row->rec_date));
                })
                ->addColumn('invNo', function ($row) {
                    return $row->inv_prefix.$row->inv_number;
                })
                ->addColumn('plan', function ($row) {
                    $userRes = getUserData($row->userid,'user_registrations');
                    if($userRes){
                        return (($userRes->acc_type == 1) ? 'Self Apply' : 'Loan Agent');
                    }
                    return '-';
                })
                ->addColumn('fullname', function ($row) {
                    $userRes = getUserData($row->userid,'user_registrations');
                    if ($userRes) {
                        $name = $userRes->first_name . ' ' . $userRes->last_name;
                        $tag = (($row->is_refund == 1) ? ' <span class="badge badge-light-danger">Refunded</span>' : '');
                        return $name . $tag
                        ;
                    }
                    return '-';
                })
                ->addColumn('mobile', function ($row) {
                    $userRes = getUserData($row->userid,'user_registrations');
                    if ($userRes) {
                        return $userRes->mobile;
                    }
                    return '-';
                })
                ->addColumn('city', function ($row) {
                    $userRes = getUserData($row->userid,'user_registrations');
                    if ($userRes) {
                        return $userRes->city;
                    }
                    return '-';
                })
                ->addColumn('state', function ($row) {
                    $userRes = getUserData($row->userid,'user_registrations');
                    if ($userRes) {
                        return $userRes->state;
                    }
                    return '-';
                })
                ->addColumn('totalAmount', function ($row) {
                    return $row->inv_grandtotal;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<ul class="action">
                                    <li class="info">
                                        <a class="" target="_blank" title="info" href="' . route('manage.selfapply.customers.invoice', ['userId' => $row->userid,'cardId' => $row->cardid]) . '">
                                            <i class="icon-info-alt"></i>
                                        </a>
                                    </li>
                                    &nbsp;&nbsp;&nbsp;
                                    <li class="undo">
                                        <a class="text-warning" href="javascript:;" title="refund" onclick="openRefundModal('.$row->id.','.$row->inv_number.')">
                                            <i class="icon-share-alt"></i>
                                        </a>
                                    </li>
                                  </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['fullname', 'action', 'totalAmount', 'mobile', 'plan', 'invNo', 'invDate'])
                ->make(true);
        }
        return view('reports::pages.invoiceData');
    }

    public function refundData(Request $request)
    {
        if ($request->ajax()) {
            $resdata = array();
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $queryRes = DB::table('refunds')->where('isDelete', 0)->orderByDesc('ref_date');
            if (!empty($fromDate) && !empty($toDate)) {
                $queryRes->whereBetween('ref_date', [$fromDate, $toDate]);
            }
            $refundData = $queryRes->get();
            if (count($refundData)) {
                foreach ($refundData as $row) {
                    $resrow = array();
                    $resrow['gstno'] = $resrow['aadharno'] = $resrow['panno'] = '';

                    $resrow['id'] = $row->id;
                    $resrow['ref_number'] = $row->ref_number;
                    $resrow['ref_date'] = $row->ref_date;
                    $resrow['ref_price'] = $row->ref_price;
                    $resrow['ref_cgst'] = $row->ref_cgst;
                    $resrow['ref_sgst'] = $row->ref_sgst;
                    $resrow['ref_igst'] = $row->ref_igst;
                    $resrow['ref_grandtotal'] = $row->ref_grandtotal;
                    $resrow['paymentid'] = $row->paymentid;

                    $responseUser = getUserData($row->userid, 'user_registrations');
                    if ($responseUser) {
                        $resrow['fullname'] = $responseUser->first_name . ' ' . $responseUser->last_name;
                        $resrow['mobile'] = $responseUser->mobile;
                        $resrow['email'] = $responseUser->email;
                        $resrow['city'] = $responseUser->city;
                        $resrow['state'] = $responseUser->state;
                        $resrow['accType'] = $responseUser->acc_type;

                        $userResDoc = userPayoutDoc($row->userid);
                        if ($userResDoc) {
                            $resrow['gstno'] = $userResDoc->gstdoc_number;
                            $resrow['aadharno'] = $userResDoc->aadharcard_number;
                            $resrow['panno'] = $userResDoc->pancard_number;
                        }
                    }
                    $resdata[] = $resrow;
                }
            }
            
            return DataTables::of($resdata)
                ->addIndexColumn()
                ->addColumn('product', function($row){
                    return $row['accType'] == 1 ? 'Self Apply' : 'Loan Agent';
                })
                ->rawColumns(['product'])
                ->make(true);
        }
        return view('reports::pages.refundData');
    }

    public function customerLeadsData($type, $acc_type)
    {
        try {
            $getLeadReport = DB::table('user_registrations as r')
                ->selectRaw('YEAR(r.update_date) as recyear, MONTH(r.update_date) as monthno, MONTHNAME(r.update_date) as recmonth, COUNT(r.id) as totaluser')
                ->where('r.acc_type', $acc_type)
                ->where('r.isUser', $type == 'leads' ? 1 : 2)
                ->where('r.isDelete', 0)
                ->groupByRaw('YEAR(r.update_date)')
                ->groupByRaw('MONTH(r.update_date)')
                ->groupByRaw('MONTHNAME(r.update_date)')
                ->orderByRaw('YEAR(r.update_date) desc, MONTH(r.update_date) desc')->get();
            return view('reports::pages.customerLeadsReport', compact('getLeadReport', 'type','acc_type'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function customerLeadsDataDateWise(Request $request, $type, $acc_type)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $startDate = date('Y-m-01', strtotime("$year-$month-01"));
        $endDate = date('Y-m-t', strtotime("$year-$month-01"));

        $allDates = $resdata = array();
        $currentDate = $startDate;
        $inc = 0;
        while ($currentDate <= $endDate) {
            $allDates[$inc]['formatted_date'] = $currentDate;
            $allDates[$inc]['recdate'] = displayDate($currentDate);
            $allDates[$inc]['totaluser'] = 0;
            $currentDate = date('Y-m-d', strtotime("$currentDate +1 day"));
            $inc++;
        }

        $queryRes = DB::table('user_registrations as r')
            ->selectRaw("DATE_FORMAT(r.update_date, '%Y-%m-%d') AS formatted_date, count(r.id) as totaluser")
            ->join('loan_applications as a', 'a.userid', '=', 'r.id')
            ->where('r.acc_type', $acc_type)
            ->where('r.isUser', $type == 'leads' ? 1 : 2)
            ->whereRaw('r.isDelete = 0 AND DATE(r.update_date)  BETWEEN  ? AND ?', [$startDate, $endDate])
            ->groupByRaw('formatted_date')->get();
        if (count($allDates)) {
            foreach ($allDates as $key => $value) {
                foreach ($queryRes as $r1) {
                    if ($allDates[$key]['formatted_date'] == $r1->formatted_date && $r1->totaluser != 0) {
                        $allDates[$key]['totaluser'] = $r1->totaluser;
                    }
                }
            }
        }
        return response()->json(['type' => 'SUCCESS', 'message' => 'success', 'data' => $allDates]);
    }
    
    public function companyGST(CompanyGSTDataTable $dataTable){
        return $dataTable->render('reports::pages.companygst');
    }
    
    /* utm sourec reports section start */
    public function utmSource(UtmSourceDataTable $dataTable){
        return $dataTable->render('reports::pages.utmsource');
    }
    
    public function refundProcess($invId, $invNo){
        return view('reports::modals.refund',compact('invId','invNo'));
    }
    
    public function refundAmtProcess(Request $request){
        try{
            $request->validate([
                'paymentid' => 'required'
            ]);
            $invData = DB::table('invoices')->where('id',$request->invoiceid)->first();
            if($invData){
                $refundNumber = date('md').random_code_num(6);
                $data = array(
    				'rec_date' => date('Y-m-d H:i:s'),
    				'userid' => $invData->userid,
    				'invoiceid' => $invData->id,
    				'ref_date' => date('Y-m-d'),
    				'ref_number' => $refundNumber,
    				'ref_price' => $invData->inv_price,
    				'ref_cgst' => $invData->inv_cgst,
    				'ref_sgst' => $invData->inv_sgst,
    				'ref_igst' => $invData->inv_igst,
    				'ref_grandtotal' => $invData->inv_grandtotal,
    				'paymentid' => $request->paymentid,
    				'remarks' => $request->remarks,
    				'isDelete' => 0
    			);
    			$res = DB::table('refunds')->insert($data);
    			$userData = DB::table('user_registrations')->where('id', $invData->userid)->first();
    			DB::table('invoices')->where('id',$invData->id)->update(['is_refund'=>1]);
    			DB::table('user_registrations')->where('id',$invData->userid)->update(['isActive'=>0]);
    			return response()->json(['type'=>'SUCCESS','message'=>'Refund successfully placed']);
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Opps!Invoice not found.']);
            }
        } catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['type'=>'ERROR','errors'=>$e->errors()],422);
        } catch(\Exception $e){
            Log::info('error occured in refund module - '. $e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops!Something went wrong while process refund']);
        }
    }
}
