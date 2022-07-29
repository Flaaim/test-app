<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;


class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $path = config('modular.path');
        $modules = config('modular.modules');
        
        if($modules){
            Route::prefix('')->group(function()use($path, $modules){

                foreach($modules as $mod => $submodules){
                    foreach($submodules as $key => $sub){
                        
                        $relativePath = "$mod/$sub"; 

                        Route::middleware('web')->group(function()use($relativePath){
                            $this->getWebRoutes($relativePath);
                        });


                        Route::prefix('api')->group(function()use($relativePath, $mod){
                            $this->getApiRoutes($relativePath, $mod);
                        });
                        
                        
                    }
                    
                }
            });
        }

        $this->app['view']->addNamespace('Pub', base_path()."/resources/views/Pub");
    }
    
    private function getWebRoutes($relativePath){
        
        $routesPath = base_path() . "/app/Modules/$relativePath/Routes/web.php";
        
        if(file_exists($routesPath)){
            $this->loadRoutesFrom(base_path("app/Modules/$relativePath/Routes/web.php"));
        }
    }

    private function getApiRoutes($relativePath, $mod){
        $routesPath = base_path() . "/app/Modules/$relativePath/Routes/api.php";
        $prefix = strtolower($mod);
            if(file_exists($routesPath)){
            Route::prefix("$prefix")->group(function()use($relativePath){
                $this->loadRoutesFrom(base_path("app/Modules/$relativePath/Routes/api.php"));
                });
            
        }
    }
    
}
