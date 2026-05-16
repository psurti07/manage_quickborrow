<?php

use Illuminate\Support\Facades\Route;
use Modules\Remarks\App\Http\Controllers\RemarksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('remarks',[RemarksController::class,'index'])->name('remarks');
    Route::get('/remarks-create', [RemarksController::class,'create'])->name('remarks.create');
    Route::post('/remarks-create-store', [RemarksController::class,'store'])->name('remarks.save');
    Route::post('/remarks-destroy', [RemarksController::class,'destroy'])->name('remarks.delete');
    Route::get('/remarks-edit/{id}', [RemarksController::class,'edit'])->name('remarks.edit');
    Route::post('/remarks-update', [RemarksController::class,'update'])->name('remarks.update');
});
