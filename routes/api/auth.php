<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');

    Route::middleware(['jwt.verify'])->group(function () {
        Route::delete('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('check', [AuthController::class, 'check'])->name('check');
    });
});
