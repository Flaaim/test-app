<?php

namespace App\Modules\Pub\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    protected $redirectedTo = '/';

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }


    public function login()
    {
        return view('Pub::Auth.login');
    }
}
