<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::middleware(['ipaddress'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'viewTasks']);
    Route::post('/createTask', [TaskController::class, 'createTask']);
    Route::put('/updateTask/{id}', [TaskController::class, 'updateTask']);
    Route::delete('/deleteTask/{id}', [TaskController::class, 'deleteTask']);
    Route::post('/tasks', [TaskController::class, 'tasksByCategory']); //send the category_name using query
});
