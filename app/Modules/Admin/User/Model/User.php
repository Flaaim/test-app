<?php

namespace App\Modules\Admin\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthUser;
use Laravel\Passport\HasApiTokens;
use App\Modules\Admin\Role\Model\Traits\UserRoles;
use App\Modules\Admin\LeadComment\Model\Traits\UserLeadsTrait;

class User extends AuthUser
{
    use HasFactory, HasApiTokens, UserRoles, UserLeadsTrait;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'status',
    ];
    protected $hidden = [
        'password'
    ];
}
