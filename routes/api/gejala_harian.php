<?php

use App\Http\Controllers\Api\GejalaHarianController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.verify'])->group(function () {
    Route::prefix('gejala_harian')->name('gejala_harian.')->group(function () {
        Route::get('/', [GejalaHarianController::class, 'index'])->name('get');
    });
});
