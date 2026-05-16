<?php

use Illuminate\Support\Facades\Route;
use Modules\Tasks\App\Http\Controllers\TasksController;
use Modules\Tasks\App\Http\Controllers\StaffTasksController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/partners-tasks', [TasksController::class, 'index'])->name('partners.tasks');
    Route::get('/partners-tasks-create', [TasksController::class, 'create'])->name('partners.tasks.create');
    Route::post('/partners-tasks-store', [TasksController::class, 'store'])->name('partners.tasks.store');

    Route::get('/staff-tasks', [StaffTasksController::class, 'index'])->name('staff.tasks');
    Route::get('/staff-tasks-create', [StaffTasksController::class, 'create'])->name('staff.tasks.create');
    Route::post('/staff-tasks-store', [StaffTasksController::class, 'store'])->name('staff.tasks.store');
    Route::post('/staff-tasks-status-change', [StaffTasksController::class, 'statusChange'])->name('staff.tasks.statuschange');
});
