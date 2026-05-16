<?php

namespace Modules\NewsLetter\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsLetterController extends Controller
{

    public function index()
    {
        return view('newsletter::index');
    }

}
