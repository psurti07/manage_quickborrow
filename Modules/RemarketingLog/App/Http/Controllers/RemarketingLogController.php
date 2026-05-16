<?php

namespace Modules\RemarketingLog\App\Http\Controllers;

use App\DataTables\RemarketingLogDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RemarketingLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RemarketingLogDataTable $dataTable)
    {
        return $dataTable->render('remarketinglog::index');
    }
    
    public function details($remarketingId){
        $data = DB::table('sms_log')->where('id', $remarketingId)->first();
        return view('remarketinglog::details',compact('data'));
    }

}
