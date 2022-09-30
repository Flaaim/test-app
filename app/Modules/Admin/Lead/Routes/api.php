<?php

use App\Modules\Admin\Lead\Controllers\Api\LeadController;


Route::prefix('leads')->group(function(){
    Route::get('/', [LeadController::class, 'index'])->name('api.leads.index');
    Route::post('/', [LeadController::class, 'store'])->name('api.leads.store');
    Route::put('/{lead}', [LeadController::class, 'update'])->name('api.leads.update');
    Route::get('/{lead}', [LeadController::class, 'show'])->name('api.leads.show');

    Route::get('/arhive/index', [LeadController::class, 'arhive'])->name('api.arhive.index');
    Route::post('/create/check', [LeadController::class, 'checkExists'])->name('api.leads.check');
    Route::put('/update/quality/{lead}', [LeadController::class, 'isQualityLead'])->name('api.leads.update.quality');
});