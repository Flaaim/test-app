<?php

use App\Modules\Admin\Role\Controllers\RoleController;
use App\Modules\Admin\Role\Controllers\PermissionController;

Route::prefix('roles')->group(function(){
    route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    route::get('/create', [RoleController::class, 'create'])->name('roles.create');
    route::get('/{role}', [RoleController::class, 'show'])->name('roles.read');
    route::get('/edit/{role}', [RoleController::class, 'edit'])->name('roles.edit');
    route::put('/{role}', [RoleController::class, 'update'])->name('roles.update');
    route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.delete');
});

Route::prefix('permissions')->group(function(){
    route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
    route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
    route::get('/edit', [PermissionController::class, 'edit'])->name('edit.permissions');
    
});