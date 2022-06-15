<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// adicionar rotas a um grupo com prefixo tasks
Route::prefix('tasks')->group(function () {
    Route::get('', [TaskController::class, 'index']);
    Route::post('', [TaskController::class, 'store']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::patch('/{id}', [TaskController::class, 'patch']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
});
