<?php

namespace Modules\Statistics\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OtpVerification;
use App\Models\SmsLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SmsLogController extends Controller
{

    public function index(){
        $todaySACount = OtpVerification::where('acc_type',1)->where('rec_date',date('Y-m-d'))->get()->count();
        $todayLACount = OtpVerification::where('acc_type',2)->where('rec_date',date('Y-m-d'))->get()->count();

        $todaySASMSStotal = SmsLog::where('parentid', 11)
                            ->whereDate('rec_date', today())
                            ->where('cronname', 'like', '%SMS Day%')
                            ->sum('msgcount');
        $todayLASMSStotal = SmsLog::where('parentid', 12)
                            ->whereDate('rec_date', today())
                            ->where('cronname', 'like', '%SMS Day%')
                            ->sum('msgcount');

        $todaySAWPtotal = SmsLog::where('parentid', 11)
                            ->whereDate('rec_date', today())
                            ->where('cronname', 'like', '%Whatsapp Day%')
                            ->sum('msgcount');
        $todayLAWPPtotal = SmsLog::where('parentid', 12)
                            ->whereDate('rec_date', today())
                            ->where('cronname', 'like', '%Whatsapp Day%')
                            ->sum('msgcount');

        return view('statistics::smsLog',compact('todaySACount','todayLACount','todaySASMSStotal','todayLASMSStotal','todaySAWPtotal','todayLAWPPtotal'));
    }
    
}
