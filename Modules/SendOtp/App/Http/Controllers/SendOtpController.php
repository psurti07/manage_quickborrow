<?php

namespace Modules\SendOtp\App\Http\Controllers;

use App\DataTables\SendOtpDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SendOtpController extends Controller
{

    public function index(SendOtpDataTable $dataTable){
        return $dataTable->render('sendotp::index');
    }

}
