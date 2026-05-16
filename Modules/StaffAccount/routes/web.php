<?php

use Illuminate\Support\Facades\Route;
use Modules\StaffAccount\App\Http\Controllers\StaffAccountController;


Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/staff-account', [StaffAccountController::class,'index'])->name('staff.account');
    Route::get('/staff-account-create', [StaffAccountController::class,'create'])->name('staff.account.create');
    Route::post('/staff-account-create-store', [StaffAccountController::class,'store'])->name('staff.account.store');
    Route::post('/staff-account-status-change', [StaffAccountController::class,'statusChange'])->name('staff.account.statuschange');
    Route::post('/staff-account-destroy', [StaffAccountController::class,'destroy'])->name('staff.account.delete');
    Route::get('/staff-account-details/{staffId}', [StaffAccountController::class,'staffDetails'])->name('staff.account.details');
    /*Route::get('/staff-account-edit/{id}', [StaffAccountController::class,'edit'])->name('staff.account.edit');*/
    Route::post('/staff-account-update', [StaffAccountController::class,'updateStaffDetails'])->name('staff.account.update');
    Route::post('/staff-account-update-password', [StaffAccountController::class,'updatePassword'])->name('staff.account.update.password');
    Route::post('/staff-account-deactivate', [StaffAccountController::class,'deactivateAccount'])->name('staff.account.deactivate');
});
