<?php

use App\Modules\Admin\Analitics\Controllers\Api\AnaliticController;

Route::prefix('analitics')->group(function(){
    Route::post('/', [AnaliticController::class, 'index'])->name('api.analitics.index');
});