<?php

use App\Http\Controllers\Web\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', [LoginController::class, 'loginGet'])->name('login.get')->middleware(['guest']);
    Route::post('login', [LoginController::class, 'loginPost'])->name('login.post')->middleware(['guest']);

    Route::get('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
});
