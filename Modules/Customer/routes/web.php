<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\App\Http\Controllers\CustomerController;


Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/selfapply/customers', [CustomerController::class, 'users'])->name('selfapply.users');
    Route::get('/selfapply/users-details/{userId}', [CustomerController::class, 'usersDetails'])->name('selfapply.customer.details');
    Route::post('/selfapply/users-details/update', [CustomerController::class, 'usersDetailsUpdate'])->name('selfapply.customers.update');
    Route::get('/selfapply/users-invoice/{userId}/{cardId}', [CustomerController::class, 'generateInvoice'])->name('selfapply.customers.invoice');
    Route::post('/selfapply/users/update-password', [CustomerController::class, 'updatePassword'])->name('selfapply.customers.update.password');
    Route::post('/selfapply/user/assign-agent', [CustomerController::class,'assignAgent'])->name('selfapply.customers.assign.agent');
    Route::post('/selfapply/user/deactivate-account',[CustomerController::class,'deactivateAccount'])->name('selfapply.customers.deactivate.account');
    Route::post('/selfapply/user/delete-account',[CustomerController::class,'deleteAccount'])->name('selfapply.customers.delete.account');
    Route::post('/selfapply/user/offer-click-counts',[CustomerController::class,'clickCounts'])->name('selfapply.customers.offers.click.count');
    
    Route::get('/selfapply/applications/{type}', [CustomerController::class, 'saApplication'])->name('selfapply.saapplications');
    Route::get('/selfapply/applications-details/{userId}', [CustomerController::class, 'saApplicationDetails'])->name('selfapply.loan.applications.details');
    
    Route::get('/selfapply/applications-details/verified-account/{id}', [CustomerController::class, 'verifiedAccount']);
    Route::post('/selfapply/applications-details/update-process', [CustomerController::class, 'updateProcess']);
    Route::get('/selfapply/applications-details/close-account/{id}', [CustomerController::class, 'closeAccount']);
    Route::post('/selfapply/applications-details/store-remarks', [CustomerController::class, 'storeRemarks'])->name('selfapply.loan.applications.store.remarks');
    Route::post('/selfapply/applications-details/delete-remarks', [CustomerController::class, 'deleteRemarks'])->name('selfapply.loan.applications.destroy.remarks');
    Route::get('/selfapply/applications-details/download-report/{userid}/{appid}', [CustomerController::class, 'downloadReport'])->name('selfapply.loan.application.download.report');
});
