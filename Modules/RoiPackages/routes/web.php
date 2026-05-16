<?php

use Illuminate\Support\Facades\Route;
use Modules\RoiPackages\App\Http\Controllers\RoiPackagesController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/roipackages', [RoiPackagesController::class,'index'])->name('roi.packages');
    Route::get('/roipackages-create', [RoiPackagesController::class,'create'])->name('roipackages.create');
    Route::post('/roipackages-store', [RoiPackagesController::class,'store'])->name('roipackages.store');
    Route::post('/roipackages-destroy', [RoiPackagesController::class,'destroy'])->name('roipackages.destroy');
    Route::get('/roipackages-edit/{id}', [RoiPackagesController::class,'edit'])->name('roipackages.edit');
    Route::post('/roipackages-update', [RoiPackagesController::class,'update'])->name('roipackages.update');
});
