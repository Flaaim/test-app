<?php

use App\Modules\Admin\LeadComment\Controllers\Api\LeadCommentController;


Route::prefix('leadComments')->group(function(){
    Route::post('/', [LeadCommentController::class, 'store'])->name('api.leadComments.store');
});