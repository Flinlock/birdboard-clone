<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectTasksController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    // For Projects
    Route::get('/projects', [ProjectsController::class, 'index']);
    Route::get('/projects/create', [ProjectsController::class, 'create']);
    Route::get('/projects/{project}', [ProjectsController::class, 'show']);
    Route::patch('/projects/{project}', [ProjectsController::class, 'update']);
    Route::post('/projects', [ProjectsController::class, 'store']);

    // For Tasks
    Route::post('/projects/{project}/tasks', [ProjectTasksController::class, 'store']);
    Route::patch('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'update']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
