<?php

namespace App\Modules\Admin\Menu\Model;

use App\Modules\Admin\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Role\Model\Permission;


class Menu extends Model
{
    use HasFactory;

    const MENU_TYPE_FRONT = 'front';
    const MENU_TYPE_ADMIN = 'admin';
    
    public function perms(){
        return $this->belongsToMany(Permission::class, 'permission_menu');
    }

    public function scopeFrontMenu($query, User $user){
        return $query->where('type', self::MENU_TYPE_FRONT)->
            whereHas('perms', function($q) use($user){

            $arr = collect($user->getMergedPermissions())->map(function($item){
                return $item['id']; 
            });
            $q->whereIn('id', $arr->toArray());
        }); 
    }

    public function scopeMenuByType($query, $type){
        return $query->where('type', $type)->orderBy('parent')->orderBy('sortorder');
        
    }


}
