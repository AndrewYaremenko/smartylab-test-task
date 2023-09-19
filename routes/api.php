<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TaskController;

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

//Есть вариант использовать Route::resource('tasks', 'TaskController'), но в данном случае решил прописать все вручную