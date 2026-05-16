<?php

use Illuminate\Support\Facades\Route;
use Modules\DND\App\Http\Controllers\DNDController;

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
    Route::get('/dnd-list/{type}', [DNDController::class,'index'])->name('dnd.list');
    Route::post('/dnd-list/process-csv', [DNDController::class,'processCSV'])->name('dnd.list.process.csv');
    Route::post('/dnd-list/destroy', [DNDController::class,'destroy'])->name('dnd.list.destroy');
});
