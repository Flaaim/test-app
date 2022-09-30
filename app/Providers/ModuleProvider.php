<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Services\Localization\LocalizationService;

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
            Route::prefix(LocalizationService::locale())->group(function()use($path, $modules){

                foreach($modules as $mod => $submodules){
                    foreach($submodules as $key => $sub){
                        
                        $relativePath = "/$mod/$sub"; 

                        Route::middleware('web')->group(function()use($relativePath, $mod){
                            $this->getWebRoutes($relativePath, $mod);
                        });


                        Route::prefix('api')
                        ->middleware('api')
                        ->group(function()use($relativePath, $mod, $sub){
                            $this->getApiRoutes($relativePath, $mod, $sub);
                        });
                        
                        
                    }
                    
                }
            });
        }

        $this->app['view']->addNamespace('Pub', base_path()."/resources/views/Pub");
        $this->app['view']->addNamespace('Admin',base_path().'/resources/views/Admin');
    }
    
    private function getWebRoutes($relativePath, $mod){
        
        $routesPath = base_path() . "/app/Modules/$relativePath/Routes/web.php";
        
        if(file_exists($routesPath)){
            if($mod != config('modular.groupWithoutPrefix')){
                $prefix = strtolower($mod);
                Route::prefix("$prefix")->group(function()use($relativePath){
                    $this->loadRoutesFrom(base_path("app/Modules/$relativePath/Routes/web.php"));
                    });
            }else {
                $this->loadRoutesFrom(base_path("app/Modules/$relativePath/Routes/web.php"));
            }
            
        }
    }

    private function getApiRoutes($relativePath, $mod, $sub){
        $routesPath = base_path() . "/app/Modules/$relativePath/Routes/api.php";
        
        if(file_exists($routesPath)){

            Route::group(
                [
                    'prefix' => strtolower($mod),
                    'middleware' => $this->getMiddleware($mod, 'api')
                ],
                function() use ($mod, $sub, $routesPath) {
                    Route::namespace("App\Modules\\$mod\\$sub\Controllers")->
                            group($routesPath);
                }
            );
            
        }
    }
    private function getMiddleware($mod, $key = 'web')
    {
        $middleware = [];

        $config = config('modular.groupMidleware');

        if(isset($config[$mod])) {
            if(array_key_exists($key, $config[$mod])) {
                $middleware = array_merge($middleware, $config[$mod][$key]);
            }
        }
        
        return $middleware;
    }
    
}
