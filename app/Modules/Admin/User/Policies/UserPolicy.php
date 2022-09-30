<?php

namespace App\Modules\Admin\User\Policies;

use App\Modules\Admin\User\Model\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return $user->canDo(['SUPER_ADMINISTRATOR', 'USER_ACCESS']);
    }
    public function create(){
        return $user->canDo(['SUPER_ADMINISTRATOR', 'USER_ACCESS']);
    }
    public function edit(){
        return $user->canDo(['SUPER_ADMINISTRATOR', 'USER_ACCESS']);
    }
    public function delete(){
        return $user->canDo(['SUPER_ADMINISTRATOR', 'USER_ACCESS']);
    }
}
