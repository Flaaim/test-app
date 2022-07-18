## modules_laravel

Памятка по реализации модульной структуры в laravel

1. Создаем новую консольную команду
```
php artisan make:command ModuleMake
```
В директории App\Console\Commands создается ModuleMake.php;

2. Устанавливает сигнатуру make:module
2.1. Определяем параметры в $signature; имя {name} тип {--all}, {--model}, {--controller} и т.д.
2.2. В методе handle проверяем какие параметры приходят, например 
```
  if($this->option('all'){
    $this->input->setOption('controller', true);
    $this->input->setOption('model', true);
    ...
    }
```
Далее, прописываем вызываемые функции отдельно для каждого модуля.
```
  Model
   if($this->option('model'))
{ 
  $this->createModel();
}
 ...
 ```
### 3. Создаем методы

  ### Model 
```
$model = $this->argument('name');// Admin
$this->call('make:model', [
'name' => "пространство имен\\".$this->argument('name')."\\Models\\."$model
]);
```
### Migration 

делается по аналогии с model
```
$table = ...
$this->call('make:migration', [
'name' => "create_$table_migration", //название
'--create' =>$table, //flag
'path' => "пространство имен\\".$this->argument('name')."\\migrations\\"
]);
```
### Controller 

создаем папку stubs в /resources, внутри создаем временные stubs файлы

логика создания контроллера 
#### function createController();
```

формируем имя контроллера, // по аналогии с получением имени model
формируем имя модели, //по аналогии с получением имени model 
формируем путь методом getControllerPath($argument //Admin\User);
проверяем путь, isDirectoryExists() если он уже создан выводим ошибку, иначе создаем указанный путь makeDirectory($path);
берем временный файл stub file_gets_content();

меняем в нем все 'маркеры' на необходимые значения
создаем контроллер по указанному пути file_puts_content();
вызываем функцию createRoutes();
обновляем modular config $this->updateModularConfig()


function getControllerPAth($argument){
  возвращает путь до создаваемого контроллера // App/Modules/[путь]/Controllers/[имя контроллера].Controller
}
```

перед созданием функции makeDirectory необходимо внедрить механизм по работе с файлами

```
private $files;
function __construct(Filesystem $filesystem)
{
  parent::__construct();
  $this->files = $filesystem;
}
```

#### function makeDirectory($path)

используя объект filesystem проверяем сущесвует ли директория.

```
if(!$this->files->isDirectory(dirname($path))){
  $this->files->makeDirectory(dirname($path), 0777, true, true); //здесь makeDirectory и isDirectory функции объекта filesystem
}
```

#### function isDirectoryExists($path)
```
function isDirectoryExists($path) 
    {
        return $this->files->exists($path);
    }
```
## Дополнительные функции
```
$this->argument('Admin\User'); // Admin\User
class_basename('Admin\User');  // User
Str::studly(): // // Test_User TestUser, Test User TestUser
Str::singular(); //Tests Test
Str::plural(); //Test Tests
trim();
```
