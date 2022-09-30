<?php

use App\Modules\Admin\Analitics\Controllers\AnaliticController;

Route::prefix('analitics')->group(function(){
    route::get('/index', [AnaliticController::class, 'index'])->name('index');
    route::get('/create', [AnaliticController::class, 'create'])->name('create');
    route::get('/edit', [AnaliticController::class, 'edit'])->name('edit');
    route::get('/show', [AnaliticController::class, 'show'])->name('show');
});