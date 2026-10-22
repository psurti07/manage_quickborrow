<?php

use Illuminate\Support\Facades\Route;
use Modules\LoanAgentCustomer\App\Http\Controllers\LoanAgentCustomerController;

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
    Route::get('/loanagent/customers', [LoanAgentCustomerController::class, 'index'])->name('loanagent.users');
    Route::get('/loanagent/customer-details/{userId}', [LoanAgentCustomerController::class, 'usersDetails'])->name('loanagent.customer.details');
    Route::post('/loanagent/customer-details/update', [LoanAgentCustomerController::class, 'usersDetailsUpdate'])->name('loanagent.customers.update');
    Route::get('/loanagent/customer-invoice/{userId}/{cardId}', [LoanAgentCustomerController::class, 'generateInvoice'])->name('loanagent.customers.invoice');
    Route::post('/loanagent/customer/update-password', [LoanAgentCustomerController::class, 'updatePassword'])->name('loanagent.customers.update.password');
    Route::post('/loanagent/user/assign-agent', [LoanAgentCustomerController::class,'assignAgent'])->name('loanagent.customers.assign.agent');
    Route::post('/loanagent/user/deactivate-account',[LoanAgentCustomerController::class,'deactivateAccount'])->name('loanagent.customers.deactivate.account');
    Route::post('/loanagent/user/delete-account',[LoanAgentCustomerController::class,'deleteAccount'])->name('loanagent.customers.delete.account');
});
