<?php

use Illuminate\Support\Facades\Route;
use Modules\LoanAgent\App\Http\Controllers\LoanAgentController;

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
], function () {
    Route::get('/loanagent/leads', [LoanAgentController::class, 'index'])->name('loanagent.company.leads');
    Route::post('/loan-agent/company-leads-info', [LoanAgentController::class, 'info'])->name('loanagent.company.leads.info');
    Route::post('/loan-agent/company-leads/block-user', [LoanAgentController::class, 'blockUser'])->name('loanagent.companyleads.block.user');
    Route::post('/loan-agent/company-leads/dnd-user', [LoanAgentController::class, 'dndUser'])->name('loanagent.companyleads.dnd.user');
    Route::post('/loan-agent/company-leads/delete-user', [LoanAgentController::class, 'destroyUser'])->name('loanagent.companyleads.destroy.user');
    Route::post('/loan-agent/company-leads/convert-customer',[LoanAgentController::class, 'convertCustomer'])->name('loanagent.companyleads.convertcustomer');
});
