<?php

use Illuminate\Support\Facades\Route;
use Modules\SiteOptions\App\Http\Controllers\SiteOptionsController;
use Modules\SiteOptions\App\Http\Controllers\AisensySettingsController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/welcome-message', [SiteOptionsController::class,'welcomeMessage'])->name('welcome-message');
    Route::post('/welcome-message/update', [SiteOptionsController::class,'welcomeMessageUpdate'])->name('welcome-message.update');

    Route::get('/account-message', [SiteOptionsController::class,'accountMessage'])->name('account-message');
    Route::post('/account-message/selfapply-message', [SiteOptionsController::class,'accountMessageUpdate'])->name('account.message.selfapply.update');
    Route::post('/account-message/loanagent-message', [SiteOptionsController::class,'accountMessageUpdate'])->name('account.message.loanagent.update');

    Route::get('/site-settings', [SiteOptionsController::class,'siteSettings'])->name('site-settings');

    Route::post('/site-settings/update-event', [SiteOptionsController::class,'updateEvent'])->name('sitesettings.update-event');
    Route::post('/site-settings/update-key', [SiteOptionsController::class,'updateKey'])->name('sitesettings.update-key');

    Route::post('/site-settings/loan-update-key', [SiteOptionsController::class,'loanUpdateKey'])->name('sitesettings.loan-update-key');
    Route::post('/site-settings/loan-update-event', [SiteOptionsController::class,'loanUpdateEvent'])->name('sitesettings.loan-update-event');
    
    Route::get('/whatsapp-settings',[SiteOptionsController::class,'whatsappSettings'])->name('whatsapp.settings');
    Route::post('/whatsapp-settings-update',[SiteOptionsController::class,'whatsappSettingsUpdate'])->name('whatsapp.settings.update');
    
    Route::get('/interakt-settings',[SiteOptionsController::class,'interaktSettings'])->name('interakt.settings');
    Route::get('/interakt-settings/edit/{id}',[SiteOptionsController::class,'interaktSettingsEdit'])->name('interakt.settings.edit');
    Route::post('/interakt-settings/update',[SiteOptionsController::class,'interaktSettingsUpdate'])->name('interakt.settings.update');
    
    Route::get('/sms-settings',[SiteOptionsController::class,'smsSettings'])->name('sms.settings');
    Route::post('/sms-settings-update',[SiteOptionsController::class,'smsSettingsUpdate'])->name('sms.settings.update');
    
    Route::get('/aisensy-settings',[AisensySettingsController::class, 'index'])->name('aisensy.settings');
    Route::get('/aisensy-settings/edit/{id}',[AisensySettingsController::class, 'edit'])->name('aisensy.settings.edit');
    Route::post('/aisensy-settings-update',[AisensySettingsController::class, 'update'])->name('aisensy.settings.update');
});
