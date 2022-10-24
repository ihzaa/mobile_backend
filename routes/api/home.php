<?php

use App\Http\Controllers\Api\AfterLoginController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.verify'])->prefix('home')->name('home.')->group(function () {
    Route::post('after_login', [AfterLoginController::class, 'after_login'])->name('after_login');
    Route::get('/', [AfterLoginController::class, 'home'])->name('index');
    Route::post('clock_in', [AfterLoginController::class, 'clock_in'])->name('clock_in');
    Route::post('clock_out', [AfterLoginController::class, 'clock_out'])->name('clock_out');
    // });
});
