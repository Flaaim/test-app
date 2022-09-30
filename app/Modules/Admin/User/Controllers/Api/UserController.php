<?php

namespace App\Modules\Admin\User\Controllers\Api;


use App\Modules\Admin\User\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Response\ResponseService;
use App\Modules\Admin\User\Services\UserService;    
use App\Modules\Admin\User\Requests\UserRequest;

class UserController extends Controller 
{
    private $service;
    public function __construct(UserService $userservice){
        $this->service = $userservice;
    }

    public function index(){
        $this->authorize('view', new User());
        $users = $this->service->getUsers();
        return ResponseService::sendJsonResponse(true, 200, [], 
        ['users'=>$users->toArray()]
        );
    }

    public function store(UserRequest $request){
        $user = $this->service->save($request, new User());
        return ResponseService::sendJsonResponse(true, 200, [], 
        ['user'=>$user->toArray()]
        );
        
    }

    public function show(User $user){
        $user = User::find($id);
        return ResponseService::sendJsonResponse(true, 200, [], 
        ['user'=>$user->toArray()]
        );
    }

    public function update(UserRequest $request, $id){
        
        $user = User::find($id);
        
        $user = $this->service->save($request, $user);
        return ResponseService::sendJsonResponse(true, 200,[],[
            'user' =>  $user->toArray()
        ]);

    }

    public function destroy($id){
        $user = User::find($id);
        $user->status = '0';
        $user->update();
        return ResponseService::sendJsonResponse(true, 200, [], 
        ['user'=>$user->toArray()]);
    }

    public function userForm(){
        $this->authorize('view', new User());

        $users = $this->service->getUsers(1);

        return ResponseService::sendJsonResponse(true, 200, [], 
        ['users'=>$users->toArray()]
        );
    }
}
