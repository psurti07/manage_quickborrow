<?php

use Illuminate\Support\Facades\Route;
use Modules\RemarketingLog\App\Http\Controllers\RemarketingLogController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/remarketing-log', [RemarketingLogController::class,'index'])->name('remarketing.log');
    Route::get('/remarketing-log/details/{id}', [RemarketingLogController::class,'details'])->name('remarketing.log.details');
});
