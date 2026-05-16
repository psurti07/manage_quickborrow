<?php

use Illuminate\Support\Facades\Route;
use Modules\ChannelPartner\App\Http\Controllers\ChannelPartnerController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/channelpartner', [ChannelPartnerController::class,'index'])->name('channelpartner');
    Route::get('/channelpartner-create', [ChannelPartnerController::class,'create'])->name('channelpartner.create');
    Route::post('/channelpartner-store', [ChannelPartnerController::class,'store'])->name('channelpartner.store');
    Route::get('/channelpartner/details/{id}', [ChannelPartnerController::class,'details'])->name('channelpartner.details');
    Route::post('/channelpartner/details/company-info/update', [ChannelPartnerController::class,'updateCompany'])->name('channelpartner.companyinfo.update');
    Route::post('/channelpartner/details/personal-info/update', [ChannelPartnerController::class,'updatePersonal'])->name('channelpartner.personalinfo.update');
    Route::post('/channelpartner/details/update-password', [ChannelPartnerController::class,'updatePassword'])->name('channelpartner.update.password');
    Route::post('/channelpartner/details/account/deactivate', [ChannelPartnerController::class,'deactivateAccount'])->name('channelpartner.account.deactivate');
    Route::post('/channelpartner/details/account/delete', [ChannelPartnerController::class,'destroy'])->name('channelpartner.account.delete');

    Route::get('/channelpartner/leads', [ChannelPartnerController::class,'channelPartnerLeads'])->name('channelpartner.leads');
    Route::get('/channelpartner/leads/details/{id}', [ChannelPartnerController::class,'channelPartnerLeadsDetails'])->name('channelpartner.leads.details');
});
