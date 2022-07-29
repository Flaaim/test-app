<?php

use App\Modules\Admin\Dashboard\Controllers\DashboardController;

Route::prefix('dashboards')->group(function(){
    route::get('/index', [DashboardController::class, 'index'])->name('index');
    route::get('/create', [DashboardController::class, 'create'])->name('create');
    route::get('/edit', [DashboardController::class, 'edit'])->name('edit');
    route::get('/show', [DashboardController::class, 'show'])->name('show');
});