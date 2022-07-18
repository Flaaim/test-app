<?php

use App\Modules\Admin\Moderator\Controllers\ModeratorController;

Route::prefix('moderators')->group(function(){
    route::get('/', [ModeratorController::class, 'index'])->name('index');
});