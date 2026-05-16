<?php

use Illuminate\Support\Facades\Route;
use Modules\SMS\App\Http\Controllers\SMSController;


Route::group([
    'prefix' => 'sms/',
    'as' => 'manage.sms.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('sms-templates', [SMSController::class, 'smsTemplates'])->name('smstemplates');
    Route::get('sms-message', [SMSController::class, 'smsMessage'])->name('smsmessage');
    Route::get('send-custom-sms', [SMSController::class, 'sendCustomSms'])->name('send.custom.sms');
    Route::get('sms-message-edit/{id}', [SMSController::class,'edit'])->name('smsmessage.edit');
    Route::post('sms-message-update', [SMSController::class,'update'])->name('smsmessage.update');
    
    Route::get('send-test-sms', [SMSController::class, 'testSms'])->name('send.test.sms');
    Route::post('get-message', [SMSController::class, 'getMessage'])->name('get.title.message');
    Route::post('fire-sms', [SMSController::class, 'fireSms'])->name('fire.sms');
    Route::post('fire-custom-sms', [SMSController::class, 'fireCustomSms'])->name('fire.custom.sms');
    
    Route::post('get-user-counts', [SMSController::class, 'getUserCounts'])->name('user.counts');
});
