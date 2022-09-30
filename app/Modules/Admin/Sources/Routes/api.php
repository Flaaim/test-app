<?php

use App\Modules\Admin\Sources\Controllers\Api\SourceController;


Route::group(['prefix'=>'sources', 'middleware' => []], function(){
    Route::get('/', [SourceController::class, 'index'])->name('api.sources.index');
    Route::post('/', [SourceController::class, 'store'])->name('api.sources.store');
    Route::put('/{source}', [SourceController::class, 'update'])->name('api.sources.update');
    Route::delete('/{source}', [SourceController::class, 'destroy'])->name('api.sources.destroy');
});
   
