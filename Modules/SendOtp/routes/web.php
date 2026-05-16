<?php

use Illuminate\Support\Facades\Route;
use Modules\SendOtp\App\Http\Controllers\SendOtpController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
],function () {
    Route::get('/sendotps', [SendOtpController::class,'index'])->name('sendotps');

});

