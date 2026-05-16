<?php

use Illuminate\Support\Facades\Route;
use Modules\Loan\App\Http\Controllers\LoanController;
use Modules\Loan\App\Http\Controllers\LoanStatusController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/loanagent/application-details/{applicationId}',[LoanController::class,'applicationDetails'])->name('selfapply.loan.application.details');
    Route::post('/selfapply/loan/application-details/delete-status', [LoanController::class, 'applicationStatusDelete'])->name('selfapply.loan.application.details.status.delete');

    Route::get('/selfapply/loan/application-status/{applicationId}',[LoanStatusController::class,'addStatus'])->name('selfapply.loan.application.status.add.status');
    Route::post('/selfapply/loan/application-status/predefined-message',[LoanStatusController::class,'predefineMessage'])->name('selfapply.loan.application.status.predefine.message');
    Route::post('/selfapply/loan/application-status/store',[LoanStatusController::class,'applicationStatusStore'])->name('selfapply.loan.application.status.create');

    Route::post('/selfapply/loan/application-status',[LoanStatusController::class,'applicationStatus'])->name('selfapply.loan.application.details.status');

    Route::get('/selfapply/loan/applications-list/{status}',[LoanController::class,'getApplicationList'])->name('selfapply.loan.application.lists');
    Route::get('/loanagent/loan/applications-list/{status}',[LoanController::class,'getLoanAgentApplicationList'])->name('loanagent.loan.application.lists');
    
    
    Route::get('/loanagent/application/initiated-call/{applicationId}', [LoanStatusController::class,'initiatedCalls'])->name('loanAgent.application.initiatedCall.add.remarks');
    Route::get('/loanagent/application/other-call/{applicationId}', [LoanStatusController::class, 'missedCalls'])->name('loanAgent.application.otherCall.add.remarks');
    Route::get('/loanagent/application/service-call/{applicationId}/{type}', [LoanStatusController::class, 'serviceCalls'])->name('loanAgent.application.serviceCall.add.remarks');
    Route::get('/loanagent/application/service-closed/{applicationId}', [LoanStatusController::class, 'serviceClosed'])->name('loanAgent.application.serviceClosed.add.remarks');
    
    Route::post('/loanagent/application/get-title', [LoanStatusController::class, 'getTitle'])->name('loanagent.application.status.title');
    
    Route::get('/loanagent/application/download-report/{userid}/{applicationid}', [LoanController::class, 'downloadReport'])->name('loanAgent.application.download.report');
    
    /* applications */
    Route::get('/loanagent/application/new-application',[LoanController::class, 'applications'])->name('loanAgent.application.new.application');
    Route::get('/loanagent/application/service-calls-application/{serviceno}',[LoanController::class, 'applications'])->name('loanAgent.application.service.calls.application');
    Route::get('/loanagent/application/initiated-calls-application',[LoanController::class, 'applications'])->name('loanAgent.application.initiated.calls.application');
    Route::get('/loanagent/application/other-calls-application',[LoanController::class, 'applications'])->name('loanAgent.application.other.calls.application');
    Route::get('/loanagent/application/closed-application',[LoanController::class, 'applications'])->name('loanAgent.application.closed.application');
    
    Route::post('/loanagent/application/delete-remark',[LoanStatusController::class, 'deleteRemark'])->name('loanAgent.application.delete.remark');
});
