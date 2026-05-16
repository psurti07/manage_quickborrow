<?php

use Illuminate\Support\Facades\Route;
use Modules\SearchData\App\Http\Controllers\SearchDataController;

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
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('search-data', [SearchDataController::class, 'index'])->name('searchdata');
    Route::post('search-data', [SearchDataController::class, 'searchData'])->name('searchdata.post');
});

