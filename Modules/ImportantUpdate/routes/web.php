<?php

use Illuminate\Support\Facades\Route;
use Modules\ImportantUpdate\App\Http\Controllers\ImportantUpdateController;


Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('important-update', [ImportantUpdateController::class,'index'])->name('important.updates');
    Route::get('/important-update-create', [ImportantUpdateController::class,'create'])->name('important.update.create');
    Route::post('/important-update-create-store', [ImportantUpdateController::class,'store'])->name('important.update.save');
    Route::post('/important-update-destroy', [ImportantUpdateController::class,'destroy'])->name('important.update.delete');
    Route::get('/important-update-edit/{id}', [ImportantUpdateController::class,'edit'])->name('important.update.edit');
    Route::post('/important-update-update', [ImportantUpdateController::class,'update'])->name('important.update.update');
    Route::post('/important-update-status-change', [ImportantUpdateController::class,'statusChange'])->name('important.update.statuschange');
});
