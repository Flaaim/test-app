<?php

use App\Modules\Admin\Sources\Controllers\SourceController;

Route::prefix('sources')->group(function(){
    route::get('/', [SourceController::class, 'index'])->name('sources.index');
    route::post('/', [SourceController::class, 'store'])->name('sources.store');
    route::get('/create', [SourceController::class, 'create'])->name('sources.create');
    route::get('/edit/{source}', [SourceController::class, 'edit'])->name('sources.edit');
    route::put('/{source}', [SourceController::class, 'update'])->name('sources.update');
    route::delete('/{source}', [SourceController::class, 'destroy'])->name('sources.destroy');
    route::get('/{source}', [SourceController::class, 'show'])->name('sources.read');
});