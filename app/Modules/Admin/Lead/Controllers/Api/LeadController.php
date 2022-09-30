<?php

namespace App\Modules\Admin\Lead\Controllers\Api;


use App\Modules\Admin\Lead\Model\Lead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Lead\Services\LeadService;
use App\Services\Response\ResponseService;
use App\Modules\Admin\Lead\Requests\LeadCreateRequest;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller 
{
    protected $service;

    public function __construct(LeadService $leadService){
        $this->service = $leadService;
    }


    public function index(){
        $this->authorize('view', Lead::class);

        $result = $this->service->getLeads();

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $result,
        ]);
    }

    public function store(LeadCreateRequest $request){
        
        $this->authorize('create', Lead::class);
        $lead = $this->service->store($request, Auth::user());

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $lead
        ]);
    }

    public function update(LeadCreateRequest $request, Lead $lead){
        $this->authorize('edit', Lead::class);
        $lead = $this->service->update($request, Auth::user(), $lead);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $lead
        ]);
    }

    public function arhive(){
        $this->authorize('view', Lead::class);

        $leads = $this->service->arhive();
        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $leads,
        ]);
    }

    public function show(Lead $lead){
        $this->authorize('view', Lead::class);
        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $lead,
        ]);
    }

    public function checkExists(Request $request){
        $this->authorize('create', Lead::class);
        $lead = $this->service->checkExists($request);
        if($lead){
            return ResponseService::sendJsonResponse(true, 200, [], [
                'item' => $lead,
            ]);
        } else {
            return ResponseService::success();
        }
    }

    public function isQualityLead(Request $request, Lead $lead){
        $this->authorize('edit', Lead::class);
        $lead = $this->service->isQualityLead($request, $lead);
        return ResponseService::sendJsonResponse(true, 200, [], [
            'item'=> $lead
        ]);
    }
}
