<?php

use App\Modules\Pub\Test\Controllers\Api\TestController;


Route::prefix('tests')->group(function(){
    route::get('/', [TestController::class, 'index'])->name('index');
});