<?php

namespace Modules\Statistics\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cardoffer;
use App\DataTables\ReferralCustomerDataTable;
use App\DataTables\OpenAccountsDataTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        return view('statistics::offerPageLog');
    }

    public function pgLog(){
        $data = paymentGatewayPayments();
        return view('statistics::pgLog',compact('data'));
    }

    public function saProcessSteps(Request $request){
        $fromDate = date('Y-m-d', strtotime('-2 days'));
        $toDate = date('Y-m-d');
        if($request->has('fromDate') && $request->has('toDate')){
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
        }
        $data = processStepsData(1, $fromDate, $toDate);
        return view('statistics::saProcess',compact('data', 'fromDate', 'toDate'));
    }
    
    public function laProcessSteps(Request $request){
        $fromDate = date('Y-m-d', strtotime('-2 days'));
        $toDate = date('Y-m-d');
        if($request->has('fromDate') && $request->has('toDate')){
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
        }
        $data = processStepsData(2, $fromDate, $toDate);
        return view('statistics::laProcess',compact('data','fromDate','toDate'));
    }
    
    public function selfApply(){
        $type = 'Self Apply';
        $data = dashboardData(1);
        return view('statistics::index',compact('type','data'));
    }
    
    public function loanAgent(){
        $type = 'Loan Agent';
        $data = dashboardData(2);
        return view('statistics::index',compact('type','data'));
    }
   
    public function staffStatistics(Request $request){
        $fromDate = date('Y-m-d');
        $toDate = date('Y-m-d');
        if($request->has('fromDate') && $request->has('toDate')){
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
        }
        
        $data = DB::table('administrations as a')
        ->leftJoin('user_registrations as u', function ($join) use ($fromDate, $toDate) {
            $join->on('u.staff_id', '=', 'a.id')
                ->whereBetween(DB::raw('DATE(u.rec_date)'), [$fromDate, $toDate])
                ->where('u.acc_type', 2)
                ->where('u.isUser', 2)
                ->where('u.isDelete', 0)
                ->where('u.isActive', 1);
        })
        ->where('a.role', 2)
        ->where('a.isDelete', 0)
        ->select(
            'a.fullname as staff_name',
            'a.isActive',
            DB::raw('COUNT(u.id) as user_count'),
            DB::raw('SUM(CASE WHEN u.process_step = 5 THEN 1 ELSE 0 END) as new_count'),
            DB::raw('SUM(CASE WHEN u.process_step IN (6, 7, 8) THEN 1 ELSE 0 END) as service_count'),
            DB::raw('SUM(CASE WHEN u.process_step = 9 THEN 1 ELSE 0 END) as initiated_count'),
            DB::raw('SUM(CASE WHEN u.process_step = 10 THEN 1 ELSE 0 END) as other_count'),
            DB::raw('SUM(CASE WHEN u.process_step = 11 THEN 1 ELSE 0 END) as closed_count')
        )
        ->groupBy('a.id', 'a.fullname', 'a.isActive')
        ->orderByDesc('user_count')
        ->get();
        return view('statistics::staffStatistics', compact('data','fromDate','toDate'));
    }
    
    public function saStaffStatistics(Request $request){
        $fromDate = date('Y-m-d');
        $toDate = date('Y-m-d');
        if($request->has('fromDate') && $request->has('toDate')){
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
        }
        
        $data = DB::table('administrations as a')
        ->leftJoin('user_registrations as u', function ($join) use ($fromDate, $toDate) {
            $join->on('u.staff_id', '=', 'a.id')
                ->whereBetween(DB::raw('DATE(u.rec_date)'), [$fromDate, $toDate])
                ->where('u.acc_type', 1)
                ->where('u.isUser', 2)
                ->where('u.isDelete', 0)
                ->where('u.isActive', 1);
        })
        ->where('a.role', 5)
        ->where('a.isDelete', 0)
        ->select(
            'a.fullname as staff_name',
            'a.isActive',
            DB::raw('COUNT(u.id) as user_count'),
            DB::raw('SUM(CASE WHEN u.process_step = 5 AND u.isVerified = 0 THEN 1 ELSE 0 END) as new_count'),
            DB::raw('SUM(CASE WHEN u.process_step = 6 THEN 1 ELSE 0 END) as closed_count'),
            DB::raw('SUM(CASE WHEN u.isVerified = 1 AND u.process_step = 5 THEN 1 ELSE 0 END) as verified_count')
        )
        ->groupBy('a.id', 'a.fullname', 'a.isActive')
        ->orderByDesc('user_count')
        ->get();
        return view('statistics::sastaffStatistics', compact('data','fromDate','toDate'));
    }
    
    public function referralCustomers(ReferralCustomerDataTable $dataTable){
        return $dataTable->render('statistics::referralCustomers');
    }
    
    public function openAccount(OpenAccountsDataTable $dataTable, $type){
        $days = (($type=='self-apply') ? 7 : 10);
        $accType = (($type=='self-apply') ? 1 : 2);
        $processStep = (($type=='self-apply') ? 6 : 'loan-agent');
        return $dataTable->with(['days'=>$days, 'acc_type'=>$accType, 'processStep' => $processStep])->render('statistics::openAccounts',compact('type'));
    }

}
