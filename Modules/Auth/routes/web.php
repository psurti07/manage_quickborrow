<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Http\Controllers\AuthController;

Route::group([
    'middleware' => ['guest','PreventBackHistory']
], function () {
    Route::get('/', [AuthController::class,'index'])->name('auth');
    Route::post('/authenticate', [AuthController::class,'authenticate'])->name('authenticate');
});
