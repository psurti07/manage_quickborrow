<?php

use Illuminate\Support\Facades\Route;
use Modules\Career\App\Http\Controllers\CareerController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/career', [CareerController::class,'index'])->name('career');
    Route::get('/careers-create', [CareerController::class,'create'])->name('career.create');
    Route::post('/careers-create-store', [CareerController::class,'store'])->name('career.save');
    Route::post('/careers-status-change', [CareerController::class,'statusChange'])->name('careers.statuschange');
    Route::post('/careers-destroy', [CareerController::class,'destroy'])->name('careers.delete');
    Route::get('/careers-edit/{id}', [CareerController::class,'edit'])->name('careers.edit');
    Route::post('/careers-update', [CareerController::class,'update'])->name('careers.update');
    Route::get('/career-enquiry', [CareerController::class,'enquiry'])->name('career.enquiry');
    Route::post('/career-enquiry-remove', [CareerController::class,'enquiryremove'])->name('careers.enquiry.delete');
});
