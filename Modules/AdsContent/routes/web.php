<?php

use Illuminate\Support\Facades\Route;
use Modules\AdsContent\App\Http\Controllers\AdsContentController;


Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/advertisements/{type}', [AdsContentController::class, 'index'])->name('advertisement');
    Route::get('/advertisements/create/{type}', [AdsContentController::class, 'create'])->name('advertisement.create');
    Route::post('/advertisements/save', [AdsContentController::class, 'save'])->name('advertisement.save');
    Route::post('/advertisements/destroy', [AdsContentController::class, 'destroy'])->name('advertisement.delete');
    Route::post('/advertisements/save/image', [AdsContentController::class, 'store'])->name('advertisement.image.save');
});
