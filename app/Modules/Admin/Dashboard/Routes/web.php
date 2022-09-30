<?php

use App\Modules\Admin\Dashboard\Controllers\DashboardController;

Route::prefix('dashboard')->group(function(){
    route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});