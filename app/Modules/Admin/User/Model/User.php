<?php

namespace App\Modules\Admin\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthUser;
use Laravel\Passport\HasApiTokens;

class User extends AuthUser
{
    use HasFactory, HasApiTokens;

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
