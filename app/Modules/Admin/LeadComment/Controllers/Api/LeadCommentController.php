<?php

namespace App\Modules\Admin\LeadComment\Controllers\Api;


use App\Modules\Admin\LeadComment\Model\LeadComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\LeadComment\Services\LeadCommentService;
use App\Modules\Admin\LeadComment\Requests\LeadCommentRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\Response\ResponseService;

class LeadCommentController extends Controller 
{
    private $service;

    public function __construct(LeadCommentService $service){
        $this->service = $service;
    }

    public function store(LeadCommentRequest $request) {
        
        $this->authorize('create', LeadComment::class);
        
        $lead = $this->service->store($request, Auth::user());
        
        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $lead
        ]);
        
    }

    public function update(){

    }
}
