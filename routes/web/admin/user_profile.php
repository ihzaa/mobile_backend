<?php

use App\Http\Controllers\Web\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/profile')->name('admin.profile.')->middleware(['auth'])->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::post('/', [ProfileController::class, 'update'])->name('update');
});
