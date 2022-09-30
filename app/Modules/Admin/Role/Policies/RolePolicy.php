<?php

namespace App\Modules\Admin\Role\Policies;

use App\Modules\Admin\User\Model\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user){
        return $user->canDo(['SUPER_ADMINISTRATOR']);
    }
    public function create(User $user){
        return $user->canDo(['SUPER_ADMINISTRATOR']);
    }

    public function edit(User $user){
        
        return $user->canDo(['SUPER_ADMINISTRATOR']);
    }
    public function delete(){
        return true;
    }
    
}
