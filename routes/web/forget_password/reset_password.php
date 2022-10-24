<?php

use App\Http\Controllers\Web\ForgetPassword\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::prefix('reset/password')->name('reset.password.')->middleware(['guest'])->group(function () {
    Route::get('/{token}', [ResetPasswordController::class, 'index'])->name('index');
    Route::post('/{token}', [ResetPasswordController::class, 'store'])->name('store');
});
