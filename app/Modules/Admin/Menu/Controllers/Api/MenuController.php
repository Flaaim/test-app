<?php

namespace App\Modules\Admin\Menu\Controllers\Api;

use App\Modules\Admin\Menu\Model\Menu;
use App\Services\Response\ResponseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Admin\Role\Model\Role;


class MenuController extends Controller 
{
    public function index(){
        
        return ResponseService::sendJsonResponse(true, 200,[], [
            'menu' => (Menu::frontMenu(Auth::user())->get())->toArray()
        ]);
    }
}
