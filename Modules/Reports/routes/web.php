<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\App\Http\Controllers\ReportsController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('reports/company-gst',[ReportsController::class,'companyGST'])->name('reports.company.gst');
    Route::get('reports/gst-data',[ReportsController::class,'gstData'])->name('reports.gst.data');
    Route::get('reports/tds-data',[ReportsController::class,'tdsData'])->name('reports.tds.data');
    Route::get('reports/invoice',[ReportsController::class,'invoiceData'])->name('reports.invoice');
    Route::get('reports/refund-data',[ReportsController::class,'refundData'])->name('reports.refund.data');
    Route::get('reports/customer-leads-data/{type}/{acc_type}',[ReportsController::class,'customerLeadsData'])->name('reports.customers.leads.data');
    Route::post('reports/customer-leads-data/date-wise/{type}/{acc_type}',[ReportsController::class,'customerLeadsDataDateWise'])->name('reports.customers.leads.datewise');
    
    /* source entry */
    // Route::get('reports/utmsource',[ReportsController::class,'utmSource'])->name('reports.utmsource');
    
    Route::get('reports/refund-process/{id}/{no}', [ReportsController::class,'refundProcess'])->name('reports.refund.process');
    Route::post('reports/refund-amount-process', [ReportsController::class,'refundAmtProcess'])->name('reports.refund.amount.process');
});
