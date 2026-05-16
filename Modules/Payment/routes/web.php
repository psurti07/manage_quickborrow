<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\App\Http\Controllers\PaymentController;

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
    // 'prefix' => 'payment',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('razorpay-log', [PaymentController::class,'phonePayLog'])->name('razorpaylog');
    Route::get('phonepe-log', [PaymentController::class,'phonePayLog'])->name('paymentlog');
    Route::get('sabpaisa-log', [PaymentController::class,'phonePayLog'])->name('subpaisalog');
    Route::get('cipherpay-log', [PaymentController::class,'phonePayLog'])->name('cipherpaylog');
    Route::get('vegaah-log', [PaymentController::class,'phonePayLog'])->name('vegaahlog');
    Route::get('zwitch-log', [PaymentController::class,'phonePayLog'])->name('zwitchlog');
    Route::get('paygic-log', [PaymentController::class,'phonePayLog'])->name('paygiclog');
    Route::get('lyra-log', [PaymentController::class,'phonePayLog'])->name('lyralog');
    Route::get('zaakpay-log', [PaymentController::class,'phonePayLog'])->name('zaakpaylog');
    Route::get('airpay-log', [PaymentController::class,'phonePayLog'])->name('airpaylog');
    Route::get('cashfree-log', [PaymentController::class,'phonePayLog'])->name('cashfreelog');
});
