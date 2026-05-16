<?php

namespace Modules\Tasks\App\Http\Controllers;

use App\DataTables\PartnerTasksDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\App\Models\Administrations;
use Modules\ChannelPartner\App\Models\ChannelPartner;

class TasksController extends Controller
{
    public function index(PartnerTasksDataTable $dataTable){
        return $dataTable->render('tasks::index');
    }

    public function create(){
        $assignees = ChannelPartner::selectRaw('id, CONCAT(first_name," ",last_name) as fullname, company_name')->where('isActive',1)->where('isDelete',0)->get();
        $followers = Administrations::selectRaw('id, fullname')->where('role',3)->where('isActive',1)->where('isDelete',0)->get();
        return view('tasks::modals.partnerTaskCreate',compact('assignees','followers'));
    }
}
