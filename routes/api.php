<?php

use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\EmployeeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SkillController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;

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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login'])->name('login');
Route::post('logout', [RegisterController::class, 'logout'])->middleware('cors', 'auth:api');


Route::middleware(['cors', 'auth:api'])->group(function () {
    Route::resource('employee', EmployeeController::class)->parameters('id');
    Route::resource('department', DepartmentController::class)->parameters('id');
    Route::resource('skill', SkillController::class)->parameters(['save' => 'id']);
    Route::resource('dashboard', DashboardController::class);
    Route::resource('role', RoleController::class)->parameters(['save' => 'id']);
    Route::resource('project', ProjectController::class)->parameters(['save' => 'id']);
    Route::resource('task', TaskController::class)->parameters('id');
});
Route::post('/card', [RegisterController::class, 'creditCardAuthorization']);
