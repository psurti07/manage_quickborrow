<?php

use Illuminate\Support\Facades\Route;
use Modules\ContactEnquiry\App\Http\Controllers\ContactEnquiryController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
],function () {
    Route::get('/contactenquiry', [ContactEnquiryController::class,'index'])->name('contactenquiry');
    Route::post('/contactenquiry-destroy', [ContactEnquiryController::class,'destroy'])->name('contactenquiry.delete');
});
