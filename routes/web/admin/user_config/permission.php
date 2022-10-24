<?php

use App\Http\Controllers\Web\Admin\UserConfig\PermissionController;
use Illuminate\Support\Facades\Route;

$permission = 'Pengaturan_User_Perizinan';

Route::prefix('admin/user_config')->name('admin.user_config.')->middleware(['auth', 'user_type:Admin'])->group(function () use ($permission) {
    Route::prefix('permission')->name('permission.')->group(function () use ($permission) {
        Route::middleware(['permission:view ' . $permission])->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('show/{id}', [PermissionController::class, 'show'])->name('show');
        });
        Route::middleware(['permission:update ' . $permission])->group(function () {
            Route::post('update/{id}', [PermissionController::class, 'update'])->name('update');
        });
        Route::middleware(['permission:delete ' . $permission])->group(function () {
            Route::get('delete/{id}', [PermissionController::class, 'delete'])->name('delete');
        });
        Route::middleware(['permission:create ' . $permission])->group(function () {
            Route::get('create', [PermissionController::class, 'createGet'])->name('createGet');
            Route::post('create', [PermissionController::class, 'createPost'])->name('createPost');
        });
    });
});
