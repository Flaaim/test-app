<?php

use App\Modules\Admin\Menu\Controllers\MenuController;

Route::prefix('menus')->group(function(){
    route::get('/index', [MenuController::class, 'index'])->name('index');
    
});