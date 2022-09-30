<?php

namespace app\Modules\Admin\Role\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Dashboard\Classes\Base;
use App\Modules\Admin\Role\Model\Role;
use App\Modules\Admin\Role\Model\Permission;
use App\Modules\Admin\Role\Services\PermissionService;
use App\Modules\Admin\Role\Requests\RoleRequest;


class PermissionController extends Base {

    public function __construct(PermissionService $permsService)
    {
        parent::__construct();
        $this->service = $permsService;
    }

    public function index(){
        $this->authorize('view', Role::class);
        $perms = Permission::all();
        $roles = Role::all();
        $this->title = 'Permission title';
        $this->content = view('Admin::Permission.index')->with([
            'perms' => $perms,
            'roles' => $roles,
            'title' => $this->title,
        ])->render();

        return $this->renderOutput();
    }

    public function store(Request $request){
        $this->authorize('create', Role::class);
            $this->service->save($request);
        return back()->with(['message' => 'Success']);
        
        
    }

}