<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
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

Route::get('/jobs', function () {
    return view('jobs.index');
});

Route::get('/jobs/create', function () {
    return view('jobs.create');
});

Route::get('/jobs/search', function () {
    return view('jobs.search');
});

Route::get('/timesheets/create', function () {
    return view('jobs.timesheet');
});

Route::get('/amount-confirm', function () {
    return view('jobs.amount-confirm');
});

Route::get('/assignee-list', function () {
    return view('jobs.assignee-list');
});

Route::get('/jobs/update-history', function () {
    return view('jobs.update-history');
});

Route::get('/jobs/workplan', function () {
    return view('jobs.workplan');
});

Route::get('/project-types/create', function () {
    return view('welcome');
});
Route::get('/priorities', function () {
    return view('priority');
});

Route::get('/configurations', function () {
    return view('configuration');
});

// Project
Route::prefix('project')->group(function () {
    Route::get('/', [ProjectController::class, 'list'])->name('project.list');
    Route::post('/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::post('/update/{id}', [ProjectController::class, 'update'])->name('project.update');
    Route::get('/delete/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');
    Route::post('/action', [ProjectController::class, 'action'])->name('project.action');
});
