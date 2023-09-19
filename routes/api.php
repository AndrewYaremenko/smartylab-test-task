<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\api\TaskController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, "index"]);
    Route::get('{id}', [TaskController::class, "show"]);
    Route::post('/', [TaskController::class, "store"]);
    Route::put('{id}', [TaskController::class, "update"]);
    Route::delete('{id}', [TaskController::class, "destroy"]);
});
