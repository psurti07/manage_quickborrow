<?php

namespace Modules\Loan\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApplicationRemarks;
use App\Models\LoanApplications;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\DataTables\ApplicationsDataTable;
use Modules\Auth\App\Models\Administrations;
use Modules\CompanyLeads\App\Models\MembershipOrder;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function applicationDetails($applicationId)
    {
        try {
            $appdetails = DB::table('loan_applications as a')
                ->select('a.*', 'r.id as userid', 'r.first_name', 'r.last_name', 'r.mobile', 'r.email', 'r.staff_id', 'r.process_step')
                ->join('user_registrations as r', 'a.userid', '=', 'r.id')
                ->where('a.isDelete', 0)
                ->where('a.id', $applicationId)
                ->first();
            if ($appdetails != "" || $appdetails != null) {
                $statuslist = DB::table('loan_application_status as s')
                    ->select('s.*', 'b.bank_name', 'l.statusname', 'l.colorclass', 'a.fullname')
                    ->join('banks as b', 's.bankid', '=', 'b.id')
                    ->join('loanstatus as l', 's.statusid', '=', 'l.id')
                    ->leftJoin('administrations as a', 's.staffid', '=', 'a.id')
                    ->where('s.isDelete', 0)
                    ->where('s.applicationid', $applicationId)
                    ->orderBy('s.statusdate', 'desc')
                    ->get();
                $agentDetails = '';
                if($appdetails->staff_id !=null){
                    $agentDetails = Administrations::where('id',$appdetails->staff_id)->first();
                }
                $offers = DB::table('user_offers')->where('userid',$appdetails->userid)->first();
                $eligibilityAmt = calEligiblity($appdetails->monthly_income, $appdetails->currentemi, (($appdetails->loan_type == 2) ? 11.5 : 12.5), $appdetails->loan_amount);
                if(!$offers){
                    $jsonData = offersBankList($appdetails->monthly_income, $appdetails->user_type, $eligibilityAmt);
                    $resId = DB::table('user_offers')->insertGetId([
                        'rec_date' => Carbon::now(),
                        'userid' => $appdetails->userid,
                        'offerdata' => $jsonData
                    ]);
                    $offers = DB::table('user_offers')->where('id', $resId)->first();
                }
                $offers = json_decode($offers->offerdata);
                $remarks = DB::table('application_remarks AS ar')
                            ->select('ar.*','lr.title','lr.remarks','lr.statusid','admin.fullname')
                            ->join('loanstatus_remarks AS lr','lr.id','=','ar.subject')
                            ->join('administrations AS admin','admin.id','=','ar.staff_id')
                            ->where('application_id',$applicationId)
                            ->orderBy('id','DESC')->get();
                return view('loan::loanApplicationDetails', compact('appdetails', 'statuslist', 'agentDetails','remarks','offers'));
            } else {
                return redirect(route('manage.selfapply.users'));
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function applicationStatusDelete(Request $request)
    {
        $result = DB::table('loan_application_status')
            ->where('id', $request->input('statusId'))
            ->where('applicationid', $request->input('applicationId'))
            ->update(['isDelete' => 1]);
        if ($result != null) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Status deleted successfully!'));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong while deleting status.'));
        }
    }

    public function getApplicationList(Request $request, $status)
    {
        if ($request->ajax()) {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $accType = $request->input('accType');
            $query = DB::table('user_registrations AS r')
                ->select('a.id', 'a.rec_date', 'a.loan_type', 'a.loan_amount', 'a.loantenure', 'a.userid', 'r.first_name', 'r.last_name', 'r.mobile')
                ->join('loan_applications AS a', 'a.userid', '=', 'r.id')
                ->where(['a.status' => $status, 'a.isDelete' => 0, 'r.isUser' => 2, 'r.isDelete' => 0, 'r.acc_type' => $accType])
                ->orderByDesc('a.rec_date');
            if ($status == 11) {
                $query->whereIn('a.userid', function ($subquery) {
                    $subquery->select('userid')
                        ->from('loan_applications')
                        ->groupBy('userid')
                        ->havingRaw('COUNT(*) > 1');
                });
            }
            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('a.rec_date', [$fromDate, $toDate]);
            }
            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->rec_date));
                })
                ->addColumn('loantype', function ($row) {
                    return $row->loan_type == 1 ? 'Personal Loan' : 'Business Loan';
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center">
                                        <a href="' . route("manage.selfapply.loan.application.details", ["applicationId" => $row->id]) . '" class=""><i class="icon-info-alt"></i></a>
                                    </li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'loantype', 'fullname', 'action'])
                ->make(true);
        }
        return view('loan::pages.applicationHistory', compact('status'));
    }

    public function getLoanAgentApplicationList(Request $request, $status)
    {
        if ($request->ajax()) {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $query = DB::table('user_registrations AS r')
                ->select('a.id', 'a.rec_date', 'a.loan_type', 'a.loan_amount', 'a.loantenure', 'a.userid', 'r.first_name', 'r.last_name', 'r.mobile')
                ->join('loan_applications AS a', 'a.userid', '=', 'r.id')
                ->where(['a.status' => $status, 'a.isDelete' => 0, 'r.isUser' => 2, 'r.isDelete' => 0, 'acc_type' => 2])
                ->orderByDesc('a.rec_date');
            if ($status == 11) {
                $query->whereIn('a.userid', function ($subquery) {
                    $subquery->select('userid')
                        ->from('loan_applications')
                        ->groupBy('userid')
                        ->havingRaw('COUNT(*) > 1');
                });
            }
            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('a.rec_date', [$fromDate, $toDate]);
            }
            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->rec_date));
                })
                ->addColumn('loantype', function ($row) {
                    return $row->loan_type == 1 ? 'Personal Loan' : 'Business Loan';
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center">
                                        <a href="' . route("manage.selfapply.loan.application.details", ["applicationId" => $row->id]) . '" class=""><i class="icon-info-alt"></i></a>
                                    </li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'loantype', 'fullname', 'action'])
                ->make(true);
        }
        return view('loan::pages.applicationHistory', compact('status'));
    }
    
    public function downloadReport($userId, $appId){
        $userData = UserRegistration::where('id',$userId)->select('first_name','last_name','staff_id','mobile','email','acc_type')->first();
        $agent = Administrations::where('id',$userData->staff_id)->select('fullname','mobile','emailid')->first();
        $membershipData = MembershipOrder::where('userid',$userId)->select('registration_date','expiry_date','card_number')->first();
        $offers = optional(DB::table('user_offers')->where('userid', $userId)->first())->offerdata;
        $offers = json_decode($offers);
        $remarks = DB::table('application_remarks AS ar')
            ->select('ar.*','lr.title','lr.remarks','lr.statusid','admin.fullname')
            ->join('loanstatus_remarks AS lr','lr.id','=','ar.subject')
            ->join('administrations AS admin','admin.id','=','ar.staff_id')
            ->where('application_id',$appId)
            ->orderBy('id','DESC')->get();
        $plan = 'Loan Agent Plan';
        $planCode = 12;
        $invoice = DB::table('invoices')->where('userid', $userId)->select('inv_prefix','inv_number')->first();
        return view('loan::pages.dwReport',compact('userData','agent','offers','remarks','plan','invoice','userId','membershipData','planCode'));
    }
    
    /* applications */
    public function applications(ApplicationsDataTable $dataTable, $service=""){
        $routeName = \Route::currentRouteName();
        // Log::info('route name - ' . $routeName);
        $page = str_ireplace('manage.loanAgent.application.','',$routeName);
        // Log::info('page - ' . $page);
        switch($page){
            case 'new.application':
                $processSteps = 5;
                $title = 'New Applications';
                break;
            case 'service.calls.application' :
                $processSteps = $service;
                $title = 'Service Calls Applications';
                break;
            case 'initiated.calls.application':
                $processSteps = 9;
                $title = 'Initiated Calls Applications';
                break;
            case 'other.calls.application':
                $processSteps = 10;
                $title = 'Other Calls Applications';
                break;
            case 'closed.application':
                $processSteps = 11;
                $title = 'Closed Applications';
                break;
            default :
                $processSteps = 0;
                $title = '';
                break;
        }
        
        // Log::info('process step - ' . $processSteps);
        // Log::info('title - ' . $title);
        $agentList = Administrations::where('role',2)->where(['isActive'=>1, 'isDelete'=>0])->get();
        return $dataTable->with('processSteps', $processSteps)->render('loan::pages.applications',compact('title','agentList'));
    }
}
