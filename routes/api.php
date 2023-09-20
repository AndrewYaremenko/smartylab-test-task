<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TaskController;
use App\Http\Controllers\api\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::middleware('auth.api.json')->group(function () {
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, "index"])->name('index');
        Route::get('{id}', [TaskController::class, "show"])->name('show');
        Route::post('/', [TaskController::class, "store"])->name('store');
        Route::put('{id}', [TaskController::class, "update"])->name('update');
        Route::delete('{id}', [TaskController::class, "destroy"])->name('destroy');
    });
});

//Есть вариант использовать Route::resource('tasks', 'TaskController'), но в данном случае решил прописать все вручную