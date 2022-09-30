<?php

use App\Modules\Admin\Role\Controllers\Api\RoleController;


Route::prefix('roles')->group(function(){
    route::get('/', [RoleController::class, 'index'])->name('index');
});