<?php

use App\Http\Controllers\Web\ForgetPassword\ForgetPasswordController;
use Illuminate\Support\Facades\Route;

Route::prefix('forget/password')->name('forget.password.')->middleware(['guest'])->group(function () {
    Route::get('/', [ForgetPasswordController::class, 'index'])->name('index');
    Route::post('/', [ForgetPasswordController::class, 'store'])->name('store');
});
