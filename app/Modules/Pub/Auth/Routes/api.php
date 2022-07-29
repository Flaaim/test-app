<?php

use App\Modules\Pub\Auth\Controllers\Api\AuthController;


Route::prefix('auths')->group(function(){
    
    route::post('/login', [AuthController::class, 'login'])->name('api.login');
});