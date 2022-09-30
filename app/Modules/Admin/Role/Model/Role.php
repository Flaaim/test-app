<?php

namespace App\Modules\Admin\Role\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Role\Model\Permission;
use App\Modules\Admin\User\Model\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'alias',
    ];


    public function perms(){
        return $this->belongsToMany(Permission::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function savePermissions($perms){
        if(!empty($perms)){
            $this->perms()->sync($perms);
        } else {
            $this->perms()->detach();
        }
    }

    public function hasPermission($alias, $require = false){
        if(is_array($alias)){
            foreach($alias as $permissionAlias){
                $hasPermissions = $this->hasPermission($permissionAlias);
                    if($hasPermissions && !$require){
                        return true;
                    }
                    elseif(!$hasPermissions && $require){
                        return false;
                    }
            }
        }else {
            
            foreach($this->perms as $permission){
               
                if($permission->alias == $alias){
                    return true;
                }
            }
        }
        return $require;
    }
}
