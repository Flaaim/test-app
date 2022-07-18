<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Str;
use Illuminate\Filesystem\Filesystem;

class MakeModule extends Command
{

    private $files;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}
    {--all}
    {--model}
    {--migration}
    {--controller}
    {--views}
    {--api}
    ';

    public function __construct(Filesystem $filesystem){
        parent::__construct();
        $this->files = $filesystem;
    }
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->option('all')){
            $this->createModel();
            $this->createMigration();
            $this->createController();
            $this->createView();
            $this->createApiController();
        }
        if($this->option('model')){
            $this->createModel();
        }
        if($this->option('migration')){
            $this->createMigration();
        }
        if($this->option('controller')){
            $this->createController();
        }
        if($this->option('views')){
            $this->createView();
        }
        if($this->option('api')){
            $this->createApiController();
        }
        
        
    }

    private function createModel(){
        $name = Str::singular(Str::studly(class_basename($this->argument('name'))));
        $this->call('make:model', [
            'name'=> "App\\Modules\\".trim($this->argument('name'))."\\Model\\$name"
        ]);
        
    }

    private function createMigration(){
        $table = class_basename($this->argument('name'));
        
        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--path' => "App\\Modules\\".trim($this->argument('name'))."\\Migrations\\",
            '--create' => $table
        ]);
    }
    
    private function createApiController(){
        $apiController = Str::studly(Str::singular(class_basename($this->argument('name'))));
        
        $controllerPath = $this->getApiControllerPath($this->argument('name'), $apiController);
        
        
        if($this->isDirectoryExists($controllerPath)){
            $this->error('Api Controller already exists');
        } else {
            
            $this->makeDirectory($controllerPath);
            $stub = file_get_contents(base_path()."\\resources\\stubs\\apicontroller.stub");
            $stub = str_replace(
                [
                'DummySpace',
                'DummyModel',
                'DummyController',
                ],
                [
                    str_replace('/', '\\', $this->argument('name')),
                    $apiController,
                    $apiController.'Controller',
                ],
                $stub
            );
           
            file_put_contents($controllerPath.".php", $stub);
            
            $this->info('Api controller created succesfully');
            
        }
        $this->createApiRoutes($apiController);
    }

    private function getApiControllerPath($path, $apiController):string
    {
        return base_path()."\\App\\Modules\\".$path."\\Controllers\Api\\".$apiController."Controller";
    }

    private function createController(){
        $controller = Str::singular(Str::studly(class_basename($this->argument('name'))));
        $controllerPath = $this->getControllerPath($this->argument('name'), $controller);
        
        if($this->isDirectoryExists($controllerPath)){
            $this->error('Controller already exists!');
        } else {
            $this->makeDirectory($controllerPath);
            $stub = file_get_contents(base_path()."\\resources\\stubs\\controller.stub");
            

            $stub = str_replace(
                [
                    'DummySpace',
                    'DummyModel',
                    'DummyController'
                ],
                [
                    str_replace('/', '\\', $this->argument('name')),
                    $controller,
                    $controller."Controller"
                ],
                $stub
            );
            file_put_contents($controllerPath, $stub);
            $this->info('Controller created succesfully');
            $this->createRoutes($controller);
        }
        
        
    }
    

    private function createView(){
        $paths = $this->getViewPath($this->argument('name'));
        
        
            foreach($paths as $path){
                if($this->isDirectoryExists($path)){
                    $this->error('View is exists');
                } else {
                    $this->makeDirectory($path);
                    

                    file_put_contents($path, '');
                }
            }
            
        
        
    }

    private function getViewPath($path)
    {
        $collections = collect([
            'index',
            'create',
            'edit',
            'show',
        ]);

        foreach($collections as $item){
            $paths[] = str_replace('/','\\', base_path()."\\resources\\views\\$path\\$item.blade.php");
        }
        return $paths;
    }

    private function getControllerPath($path, $controller){
        return app_path()."\\Modules\\".$path."\\Controllers\\".$controller."Controller.php";
    }

    private function createApiRoutes($apiController){
        $routePath = $this->getRoutesApiPath($this->argument('name'));
        
        if($this->isDirectoryExists($routePath)){
            $this->error('Routes is already exists');
        }else {
            $this->makeDirectory($routePath);

            $stub = file_get_contents(base_path()."\\resources\\stubs\\route.api.stub");
            $stub = str_replace(
                [
                    'DummySpace',
                    'DummyController',
                    'DummyRoutePrefix'
                ],
            [
                str_replace('/', '\\', $this->argument('name')),
                $apiController."Controller",
                Str::plural(lcfirst($apiController))
            ],
            $stub
        );
            
            file_put_contents($routePath, $stub);


        }




    }

    private function createRoutes($controller){
       $routePath = $this->getRoutesPath($this->argument('name'));
      
        if($this->isDirectoryExists($routePath)){
            $this->error('Routes already exists!');
        }else {
           $this->makeDirectory($routePath);
            
            $stub = file_get_contents(base_path()."\\resources\\stubs\\route.stub");

            $stub = str_replace(
                ['DummyRoutePrefix', 
                'DummyController',
                'DummySpace',
                ],
                [
                    Str::plural(lcfirst($controller)),
                    $controller."Controller",
                    str_replace('/', '\\', $this->argument('name')),
                ],
                $stub
            );
            file_put_contents($routePath, $stub);
            $this->info('Route created succesfully!');
        }
    }
    private function getRoutesApiPath($path):string
    {
        return base_path()."\\App\\Modules\\".$path."\\Routes\\api.php";
    }
    private function getRoutesPath($path){
       
        return app_path()."\\Modules\\".$path."\\Routes\\web.php";
    }

    private function isDirectoryExists($path):bool 
    {
        return $this->files->exists($path);
    }
    
    private function makeDirectory($path){
        if(!$this->files->isDirectory(dirname($path))){
            mkdir(dirname($path), 0777, true);
        }
        return $path;
    }
    
    
    
    

}
