<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('team', 'TeamCrudController');
    Route::crud('employee', 'EmployeeCrudController');
    Route::crud('current-release', 'CurrentReleaseCrudController');
    Route::crud('completed-release', 'CompletedReleaseCrudController');
    Route::crud('task', 'TaskCrudController');
    Route::crud('monthly-report', 'MonthlyReportCrudController');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('backpack.dashboard');

}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
