<?php

namespace App\Modules\Admin\Role\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Admin\Role\Model\Role;

class PermissionService {
    
    public function save(Request $request)
    {
        $roles = Role::all();
        $data = $request->except('_token');
        
        foreach($roles as $role){
            if(isset($data[$role->id])){
               $role->savePermissions($data[$role->id]);
                
            } else {
                $role->savePermissions([]);
            }
        }
        
        return true;
    }

}