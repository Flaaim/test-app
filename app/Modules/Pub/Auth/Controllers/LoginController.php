<?php

namespace App\Modules\Pub\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Modules\Admin\User\Models\User;


class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    private $redirectTo = '/admin/dashboard';

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('Pub::Auth.login');
    }
}
