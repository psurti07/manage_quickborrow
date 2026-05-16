<?php

use Illuminate\Support\Facades\Route;
use Modules\Banks\App\Http\Controllers\BanksController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/banks', [BanksController::class,'index'])->name('banks');
    Route::get('/banks-create', [BanksController::class,'create'])->name('banks.create');
    Route::post('/banks-create-store', [BanksController::class,'store'])->name('banks.save');
    Route::post('/banks-status-change', [BanksController::class,'statusChange'])->name('banks.statuschange');
    Route::post('/banks-destroy', [BanksController::class,'destroy'])->name('banks.delete');
    Route::get('/banks-edit/{id}', [BanksController::class,'edit'])->name('banks.edit');
    Route::post('/banks-update', [BanksController::class,'update'])->name('banks.update');
});
