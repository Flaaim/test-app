<?php

use App\Modules\Pub\Auth\Controllers\LoginController;

Route::prefix('auths')->group(function(){
    route::get('/login', [LoginController::class, 'login'])->name('login');
});