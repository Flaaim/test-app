<?php

namespace App\Modules\Admin\Analitics\Policies;

use App\Modules\Admin\User\Model\User;
use Illuminate\Auth\Access\HandlesAuthorization;

trait AnaliticsPolicy
{
    public function viewAnalitics(User $user){
        return $user->canDo(['SUPER_ADMINISTRATOR', 'ANALITICS_ACCESS']);
    }

}
