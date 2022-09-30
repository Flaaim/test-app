<?php


namespace App\Modules\Admin\Role\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Dashboard\Classes\Base;
use App\Modules\Admin\Role\Model\Role;
use App\Modules\Admin\Role\Services\RoleService;
use App\Modules\Admin\Role\Requests\RoleRequest;

class RoleController extends Base {
    
    public function __construct(RoleService $roleService)
    {
        parent::__construct();
        $this->service = $roleService;
    }

    public function index(){
        $this->authorize('view', Role::class);
        $roles = Role::all();
        $this->title = 'Role title';
        $this->content = view('Admin::Role.index')->with([
            'roles' => $roles,
            'title' => $this->title,
        ])->render();
        return $this->renderOutput();
    }

    public function create(){
        $this->authorize('create', Role::class);
        $this->title = 'Role create';
        $this->content = view('Admin::Role.create')->with([
            'title' => $this->title,
        ])->render();
        return $this->renderOutput();

    }

    public function store(RoleRequest $request){
        //Сохранение данных в базе данных.
        
        $this->service->save($request, new Role());
        return \Redirect::route('roles.index')->with(['message' => 'Success']);
       
    }

    public function edit(Role $role){
        
        $this->authorize('edit', Role::class);
        
        
        $this->title = 'Role edit';
        $this->content = view('Admin::Role.edit')->with([
            'item' => $role,
            'title' => $this->title,
        ])->render();
        return $this->renderOutput();

    }
    public function update(RoleRequest $request, Role $role){
        $this->service->save($request, $role);
        return \Redirect::route('roles.index')->with(['message' => 'Success']);
       
    }
    public function destroy(Role $role){
        $role->delete();
        return \Redirect::route('roles.index')->with(['message' => 'Success']);
    }
}

