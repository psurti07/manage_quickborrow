<?php

use Illuminate\Support\Facades\Route;
use Modules\SupportRequest\App\Http\Controllers\SupportRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
],function () {
    Route::get('support-request', [SupportRequestController::class,'index'])->name('supportrequest');
    Route::get('support-request/ticket-details/{id}', [SupportRequestController::class,'ticketDetails'])->name('supportrequest.ticketdetails');
    Route::post('support-request/add-support-remarks', [SupportRequestController::class,'addSupportRemarks'])->name('supportrequest.addSupportRemarks');
    Route::post('support-request/change-support-status', [SupportRequestController::class,'changeSupportStatus'])->name('supportrequest.changeSupportStatus');
});
