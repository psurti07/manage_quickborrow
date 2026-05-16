<?php

use Illuminate\Support\Facades\Route;
use Modules\Offers\App\Http\Controllers\OffersController;

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
    Route::get('offers/{type}', [OffersController::class,'index'])->name('offers');
    Route::post('offers/convert', [OffersController::class,'convertOfferUser'])->name('offers.convert');
});
