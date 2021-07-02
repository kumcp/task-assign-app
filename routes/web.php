<?php

use App\Http\Controllers\JobsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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
})->name('jobs');

Route::get('/jobs/create', function () {
    return view('jobs.create');
})->name('jobs.create');

Route::get('/jobs/search', function () {
    return view('jobs.search');
})->name('jobs.search');

Route::get('/jobs/show', function () {
    return view('jobs.show');
})->name('jobs.show');

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

Route::get('/jobs', [JobsController::class, 'index']);
Route::get('/jobs/create', [JobsController::class, 'create']);
Route::get('/jobs/edit', [JobsController::class, 'edit']);
Route::get('/jobs/{id}', [JobsController::class, 'show']);
Route::post('/jobs', [JobsController::class, 'store'])->name('jobs.store');
Route::put('/jobs/{id}', [JobsController::class, 'update']);
Route::delete('/jobs/{id}', [JobsController::class, 'delete']);


Route::get('/projects', [ProjectsController::class, 'index']);
Route::get('/projects/{id}', [ProjectsController::class, 'show']);
Route::get('/projects/create', [ProjectsController::class, 'create']);
Route::post('/projects', [ProjectsController::class, 'store']);
Route::get('/projects/{id}/edit', [ProjectsController::class, 'edit']);
Route::put('/projects/{id}', [ProjectsController::class, 'update']);
Route::delete('/projects/{id}', [ProjectsController::class, 'destroy']);


// Route::post('/test', [TestController::class, 'store']);
// Route::put('/test1', [TestController::class, 'update']);
