<?php

use Illuminate\Support\Facades\Route;
use Modules\CompanyLeads\App\Http\Controllers\CompanyLeadsController;


Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/selfapply/leads', [CompanyLeadsController::class, 'companyLeads'])->name('selfapply.company.leads');
    Route::post('/selfapply/company-leads-info', [CompanyLeadsController::class, 'info'])->name('selfapply.company.leads.info');
    Route::post('/selfapply/company-leads/block-user', [CompanyLeadsController::class, 'blockUser'])->name('selfapply.companyleads.block.user');
    Route::post('/selfapply/company-leads/dnd-user', [CompanyLeadsController::class, 'dndUser'])->name('selfapply.companyleads.dnd.user');
    Route::post('/selfapply/company-leads/delete-user', [CompanyLeadsController::class, 'destroyUser'])->name('selfapply.companyleads.destroy.user');
    Route::post('/selfapply/company-leads/convert-customer',[CompanyLeadsController::class, 'convertCustomer'])->name('selfapply.companyleads.convertcustomer');
});
