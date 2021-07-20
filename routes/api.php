<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\UpdateJobHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('department', [DepartmentController::class, 'index'])->name('deparment.list');

Route::get('jobs/{id}', [JobsController::class, 'show'])->name('jobs.show');

Route::get('update-job-histories', [UpdateJobHistoryController::class, 'index'])->name('update_job_histories.index');
