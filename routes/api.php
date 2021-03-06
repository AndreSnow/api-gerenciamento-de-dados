<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('tasks')->group(function () {
    Route::get('', [TaskController::class, 'index']);
    Route::get('approved/{file_id}', [TaskController::class, 'listApproved']);
    Route::post('', [TaskController::class, 'store']);
    Route::post('tag', [TaskController::class, 'storeTag']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::patch('/{id}', [TaskController::class, 'patch']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
});
