<?php

use App\Http\Controllers\InvoiceSyncController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Partnersturnover;

Route::get('error',function(){ return view('error'); });

/*Route::get('/selfapplyForJune',[Partnersturnover::class, 'selfapplyForJune']);*/
Route::get('/selfapplyTurnover',[Partnersturnover::class, 'selfapply']);
Route::get('/hireagentTurnover',[Partnersturnover::class, 'hireagent']);

Route::post('/sync-invoice-data', [InvoiceSyncController::class, 'syncInvoiceData']);