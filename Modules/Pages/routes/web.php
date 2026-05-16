<?php

use Illuminate\Support\Facades\Route;
use Modules\Pages\App\Http\Controllers\PagesController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/privacy-policy', [PagesController::class,'privacyPolicy'])->name('privacy-policy');
    Route::post('/privacy-policy/update', [PagesController::class,'privacyPolicyUpdate'])->name('privacy-policy.update');

    Route::get('/disclaimer', [PagesController::class,'disclaimer'])->name('disclaimer');
    Route::post('/disclaimer/update', [PagesController::class,'disclaimerUpdate'])->name('disclaimer.update');

    Route::get('/terms-conditions', [PagesController::class,'termsCondition'])->name('terms-conditions');
    Route::post('/terms-conditions/update', [PagesController::class,'termsConditionUpdate'])->name('terms-conditions.update');

    Route::get('/refund-policy', [PagesController::class,'refundPolicy'])->name('refund-policy');
    Route::post('/refund-policy/update', [PagesController::class,'refundPolicyUpdate'])->name('refund-policy.update');
});
