<?php

use Illuminate\Support\Facades\Route;
use Modules\Statistics\App\Http\Controllers\SmsLogController;
use Modules\Statistics\App\Http\Controllers\StatisticsController;

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
    'prefix' => 'statistics',
    'as' => 'manage.statistics.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/sms-statistics',[SmsLogController::class,'index'])->name('sms.log');
    Route::get('/offer-page-statistics',[StatisticsController::class,'index'])->name('offer.page.log');
    Route::get('/payment-gateway-statistics',[StatisticsController::class,'pgLog'])->name('payment.gateway.log');
    
    Route::match(['get','post'],'/self-apply/process-steps',[StatisticsController::class,'saProcessSteps'])->name('self.apply.process.steps');
    Route::match(['get','post'],'/loan-agent/process-steps',[StatisticsController::class,'laProcessSteps'])->name('loan.agent.process.steps');
    
    Route::get('/loan-agent',[StatisticsController::class,'loanAgent'])->name('loan.agent');
    Route::get('/self-apply',[StatisticsController::class,'selfApply'])->name('self.apply');
    
    Route::match(['get','post'],'/loan-agent/staff-statistics',[StatisticsController::class,'staffStatistics'])->name('loan.agent.staff.stats');
    Route::match(['get','post'],'/self-apply/staff-statistics',[StatisticsController::class,'saStaffStatistics'])->name('self.apply.staff.stats');
    
    /* referral customers list */
    Route::get('referral-customers',[StatisticsController::class, 'referralCustomers'])->name('referral.customers');
    
    Route::get('open-accounts/{type}',[StatisticsController::class, 'openAccount'])->name('open.accounts');
});
