<?php

use App\Modules\Admin\User\Controllers\UserController;

Route::prefix('users')->group(function(){
    route::get('/test', [UserController::class, 'index'])->name('index');
});