<?php

use App\Http\Controllers\AssigneeListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeSheetController;

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

Route::redirect('/', '/jobs', 301);


Route::get('/jobs', function () {
    return view('jobs.index');
});

Route::get('/jobs/create', function () {
    return view('jobs.create');
});

Route::get('/jobs/search', function () {
    return view('jobs.search');
});



Route::get('/amount-confirm', function () {
    return view('jobs.amount-confirm');
});

Route::get('/assignee-list', [AssigneeListController::class, 'index'])->name('assignee-list');

Route::get('/jobs/update-history', function () {
    return view('jobs.update-history');
});

Route::get('/jobs/workplan', function () {
    return view('jobs.workplan');
});
Route::get('/projects/create', function () {
    return view('project');
});

Route::get('/project-types/create', function () {
    return view('project-type');
});
Route::get('/priorities', function () {
    return view('priority');
});

Route::get('/configurations', function () {
    return view('configuration');
});

//=================TIME SHEET===============================

Route::prefix('/timesheets')->group(function () {
    Route::get('/', [TimeSheetController::class, 'create'])->name('timesheet.create');
    Route::post('/store',[TimeSheetController::class, 'store'])->name('timesheet.store');
    Route::get('/edit/{id}', [TimeSheetController::class, 'edit'])->name('timesheet.edit');
    Route::post('/update/{id}', [TimeSheetController::class, 'update'])->name('timesheet.update');
    Route::get('/delete/{id}', [TimeSheetController::class, 'destroy'])->name('timesheet.destroy');
});