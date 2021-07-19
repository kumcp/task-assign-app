<?php

use App\Http\Controllers\AssigneeListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProcessMethodController;
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
})->name('jobs');

Route::get('/jobs/create', function () {
    return view('jobs.create');
})->name('jobs.create');

Route::get('/jobs/search', function () {
    return view('jobs.search');
})->name('jobs.search');


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

Route::get('/project-types/create', function () {
    return view('welcome');
});
Route::get('/priorities', function () {
    return view('priority');
});

Route::get('/configurations', function () {
    return view('configuration');
});



//================================== ROUTE VIEW =====================================================//

// Project
Route::prefix('project')->group(function () {
    Route::get('/', [ProjectController::class, 'list'])->name('project.list');
    Route::post('/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::post('/update/{id}', [ProjectController::class, 'update'])->name('project.update');
    Route::get('/delete/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');
});

// Project-Type
Route::prefix('project-type')->group(function () {
    Route::get('/', [ProjectTypeController::class, 'list'])->name('project-type.list');
    Route::post('/store', [ProjectTypeController::class, 'store'])->name('project-type.store');
    Route::get('/edit/{id}', [ProjectTypeController::class, 'edit'])->name('project-type.edit');
    Route::post('/update/{id}', [ProjectTypeController::class, 'update'])->name('project-type.update');
    Route::get('/delete/{id}', [ProjectTypeController::class, 'destroy'])->name('project-type.destroy');
});

// Priorities
Route::prefix('priority')->group(function () {
    Route::get('/', [PriorityController::class, 'list'])->name('priority.list');
    Route::post('/store', [PriorityController::class, 'store'])->name('priority.store');
    Route::get('/edit/{id}', [PriorityController::class, 'edit'])->name('priority.edit');
    Route::post('/update/{id}', [PriorityController::class, 'update'])->name('priority.update');
    Route::get('/delete/{id}', [PriorityController::class, 'destroy'])->name('priority.destroy');
});

//Skills
Route::prefix('skill')->group(function () {
    Route::get('/', [SkillController::class, 'list'])->name('skill.list');
    Route::post('/store', [SkillController::class, 'store'])->name('skill.store');
    Route::get('/edit/{id}', [SkillController::class, 'edit'])->name('skill.edit');
    Route::post('/update/{id}', [SkillController::class, 'update'])->name('skill.update');
    Route::get('/delete/{id}', [SkillController::class, 'destroy'])->name('skill.destroy');
});

// Process Method
Route::prefix('process-method')->group(function () {
    Route::get('/', [ProcessMethodController::class, 'list'])->name('process-method.list');
    Route::post('/store', [ProcessMethodController::class, 'store'])->name('process-method.store');
    Route::get('/edit/{id}', [ProcessMethodController::class, 'edit'])->name('process-method.edit');
    Route::post('/update/{id}', [ProcessMethodController::class, 'update'])->name('process-method.update');
    Route::get('/delete/{id}', [ProcessMethodController::class, 'destroy'])->name('process-method.destroy');
});

//Time Sheet
Route::prefix('/timesheets')->group(function () {
    Route::get('/', [TimeSheetController::class, 'create'])->name('timesheet.create');
    Route::post('/store',[TimeSheetController::class, 'store'])->name('timesheet.store');
    Route::get('/edit/{id}', [TimeSheetController::class, 'edit'])->name('timesheet.edit');
    Route::post('/update/{id}', [TimeSheetController::class, 'update'])->name('timesheet.update');
    Route::get('/delete/{id}', [TimeSheetController::class, 'destroy'])->name('timesheet.destroy');
});

//Timesheet Statictics
Route::get('/timesheet-statistics',[TimesheetStatisticsController::class, 'list'])->name('timesheet-statis.list');
Route::post('/timesheet-statistics-search',[TimesheetStatisticsController::class, 'search'])->name('timesheet-statis.search');

//Project Plan
Route::get('/project-plan', [ProjectPlanController::class, 'list'])->name('project-plan.list');
Route::post('/project-plan-search', [ProjectPlanController::class, 'search'])->name('project-plan.search');