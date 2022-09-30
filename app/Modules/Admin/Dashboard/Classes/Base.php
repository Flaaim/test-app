<?php 

namespace App\Modules\Admin\Dashboard\Classes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Modules\Admin\Menu\Model\Menu as MenuModel;
use Menu;

class Base extends Controller {
    protected $template;
    protected $user;
    protected $title;
    protected $content;
    protected $vars;
    protected $sidebar;
    protected $locale;
    protected $service;

    public function __construct()
    {
        $this->template = "Admin::Dashboard.dashboard";
        
        $this->middleware(function($request, $next) {
            $this->user = Auth::user();
            $this->locale = App::getLocale();
            return $next($request);
        });
 
    }

    protected function renderOutput() {
        $menu = $this->getMenu();
        
        $this->vars = Arr::add($this->vars, 'content', $this->content);
        $this->sidebar = view('Admin::layouts.parts.sidebar')->with([
            'menu' => $menu,
            'user' => $this->user
        ])->render(); 
        $this->vars = Arr::add($this->vars, 'sidebar', $this->sidebar);
        
        return view($this->template)->with($this->vars);
    }

    protected function getMenu(){
        return Menu::make('menuRenderer', function($m){
            foreach(MenuModel::menuByType(MenuModel::MENU_TYPE_ADMIN)->get() as $item){
                $path = $item->path;
                
                
                if($path && $this->checkRoutes($path) == true){
                    $path = route($path);
                   
                } 

                if($item->parent == 0){
                    $m->add($item->title, $path)->id($item->id)->data('permissions', $this->getPermissions($item));
                } else {
                    if($m->find($item->parent)){
                        $m->find($item->parent)->add($item->title, $path)->id($item->id)->data('permissions', $this->getPermissions($item));
                    }
                    
                }
                
            }
            
        })->filter(function($item){
            if($this->user && $this->user->canDo($item->data('permissions'))){
                return true;
            }
                return false;
            
           
        });
    }
    protected function checkRoutes($path){
      
        $routes = \Route::getRoutes()->getRoutes();
        foreach($routes as $route){
            if($route->getName() == $path){
                return true;
            }
        }
        return false;
    }

    private function getPermissions($item){
        return $item->perms->map(function($item){
            return $item->alias;
        })->toArray();
    }
}
