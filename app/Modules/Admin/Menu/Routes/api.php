<?php

use App\Modules\Admin\Menu\Controllers\Api\MenuController;


Route::prefix('menus')->group(function(){
    route::get('/', [MenuController::class, 'index'])->name('api.menus');
});