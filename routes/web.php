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
        
        // Rutas expedientes
        Route::get('/expedientes', [App\Http\Controllers\ExpedienteController::class, 'index'])->name('expedientes.index');
        Route::get('/expedientes/buscar', [App\Http\Controllers\ExpedienteController::class, 'search'])->name('expedientes.search');
        Route::get('/expedientes/{mascota}/consultas', [App\Http\Controllers\ExpedienteController::class, 'consultas'])->name('expedientes.consultas');
        Route::get('/expedientes/{mascota}/consultas/{consulta}', [App\Http\Controllers\ExpedienteController::class, 'consultaDetalle'])->name('expedientes.consulta_detalle');
        Route::get('/expedientes/{mascota}/consultas/{consulta}/diagnostico', [App\Http\Controllers\ExpedienteController::class, 'diagnostico'])->name('expedientes.diagnostico');
    });

    // Rutas administrador
    Route::middleware('role:administrador')->prefix('admin')->group(function () {
        Route::get('/home',[AuthController::class,'adminHome'])->name('admin.home');
        Route::get('/usuarios',[App\Http\Controllers\Admin\UserController::class,'index'])->name('admin.users.index');
        Route::get('/usuarios/crear',[App\Http\Controllers\Admin\UserController::class,'create'])->name('admin.users.create');
        Route::post('/usuarios',[App\Http\Controllers\Admin\UserController::class,'store'])->name('admin.users.store');
        Route::get('/usuarios/{usuario}/editar',[App\Http\Controllers\Admin\UserController::class,'edit'])->name('admin.users.edit');
        Route::put('/usuarios/{usuario}',[App\Http\Controllers\Admin\UserController::class,'update'])->name('admin.users.update');
        Route::get('/usuarios/{usuario}/eliminar',[App\Http\Controllers\Admin\UserController::class,'show'])->name('admin.users.show');
        Route::delete('/usuarios/{usuario}',[App\Http\Controllers\Admin\UserController::class,'destroy'])->name('admin.users.destroy');
        
        Route::resource('veterinarios', App\Http\Controllers\Admin\VeterinarioController::class)->names('admin.veterinarios');
        Route::get('/historial-usuarios', [App\Http\Controllers\Admin\HistorialUsuarioController::class, 'index'])->name('admin.historial_usuarios.index');
    });
});
