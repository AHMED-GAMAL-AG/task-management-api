<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('tasks', TaskController::class);

Route::get('tasks/status/{status}', [TaskController::class, 'tasksByStatus']);
Route::get('tasks/due-date/{date}', [TaskController::class, 'tasksDueWithinRange']);

// Route::post('tasks', [TaskController::class, 'store']);
// Route::put('tasks/{task}', [TaskController::class, 'update']);
// Route::delete('tasks/{task}', [TaskController::class, 'destroy']);
// Route::get('tasks/{task}',  [TaskController::class, 'show']);
// Route::get('tasks', [TaskController::class, 'index']);
