<?php

use App\Modules\Pub\Auth\Controllers\LoginController;

Route::prefix('auths')->group(function(){
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});