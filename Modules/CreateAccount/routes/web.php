<?php

use Illuminate\Support\Facades\Route;
use Modules\CreateAccount\App\Http\Controllers\CreateAccountController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('create-account', [CreateAccountController::class, 'index'])->name('create.account');
    Route::post('create-account-store', [CreateAccountController::class, 'store'])->name('create.account.store');
    Route::post('postal-details', [CreateAccountController::class, 'postalDetails'])->name('postal.details');
});
