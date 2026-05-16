<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssociatePartners;
use App\Http\Controllers\SyncDataController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/associatepartners',[AssociatePartners::class, 'index']);
Route::post('/associatepartners/todayRoyalty',[AssociatePartners::class, 'todayRoyalty']);
Route::post('/sync-data',[SyncDataController::class, 'syncData']);
