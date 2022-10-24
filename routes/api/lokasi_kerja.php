<?php

use App\Http\Controllers\Api\LokasiKerjaController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.verify'])->group(function () {
    Route::prefix('lokasi_kerja')->name('lokasi_kerja.')->group(function () {
        Route::get('/', [LokasiKerjaController::class, 'index'])->name('get');
    });
});
