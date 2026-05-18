<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function () {
    Route::get('/',[AuthController::class, 'index'])->name('login');
    Route::post('/logear',[AuthController::class,'logear'])->name('logear');
});

Route::middleware("auth")->group(function () {
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');

    // Rutas veterinario
    Route::middleware('role:veterinario')->group(function () {
        Route::get('/home',[AuthController::class,'home'])->name('home');
    });

    // Rutas administrador
    Route::middleware('role:administrador')->prefix('admin')->group(function () {
        Route::get('/home',[AuthController::class,'adminHome'])->name('admin.home');
        Route::get('/usuarios',[App\Http\Controllers\Admin\UserController::class,'index'])->name('admin.users.index');
        Route::get('/usuarios/crear',[App\Http\Controllers\Admin\UserController::class,'create'])->name('admin.users.create');
        Route::post('/usuarios',[App\Http\Controllers\Admin\UserController::class,'store'])->name('admin.users.store');
    });
});
