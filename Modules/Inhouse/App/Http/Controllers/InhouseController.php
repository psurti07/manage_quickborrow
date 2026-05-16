<?php

namespace Modules\Inhouse\App\Http\Controllers;

use App\DataTables\InhouseDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InhouseController extends Controller
{
    public function index(InhouseDataTable $dataTable){
        return $dataTable->render('inhouse::index');
    }
}
