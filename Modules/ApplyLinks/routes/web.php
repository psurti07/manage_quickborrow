<?php

use Illuminate\Support\Facades\Route;
use Modules\ApplyLinks\App\Http\Controllers\ApplyLinksController;

Route::group([
    'prefix' => 'manage',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/apply-links', [ApplyLinksController::class,'index'])->name('apply.links');
    Route::get('/apply-links-create', [ApplyLinksController::class,'create'])->name('apply.links.create');
    Route::post('/apply-links-create-store', [ApplyLinksController::class,'store'])->name('apply.links.store');
    Route::post('/apply-links-status-change', [ApplyLinksController::class,'statusChange'])->name('apply.links.statuschange');
    Route::post('/apply-links-destroy', [ApplyLinksController::class,'destroy'])->name('apply.links.destroy');
    Route::get('/apply-links-edit/{id}', [ApplyLinksController::class,'edit'])->name('apply.links.edit');
    Route::post('/apply-links-update', [ApplyLinksController::class,'update'])->name('apply.links.update');
});
