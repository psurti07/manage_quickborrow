<?php

use Illuminate\Support\Facades\Route;
use Modules\Inhouse\App\Http\Controllers\InhouseController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/inhouse-staff-tasks', [InhouseController::class, 'index'])->name('inhouse.staff.tasks');
});
