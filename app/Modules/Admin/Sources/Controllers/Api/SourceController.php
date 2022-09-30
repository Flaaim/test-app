<?php

namespace App\Modules\Admin\Sources\Controllers\Api;


use App\Modules\Admin\Sources\Models\Source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Sources\Requests\SourceRequest;
use App\Services\Response\ResponseService;
use App\Modules\Admin\Sources\Services\SourcesService;

class SourceController extends Controller 
{
    private $services;

    public function __construct(SourcesService $sourceservice){
        $this->services = $sourceservice;
    }


    public function index(){
        $this->authorize('view', new Source());
        return ResponseService::sendJsonResponse(true, 200, [], [
            'items'=> $this->services->getSources(),
        ]);
    }

    public function store(SourceRequest $request, Source $source){
        $source = $this->services->save($request, new Source());
        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $source->toArray(),
        ]);
    }

    public function update(SourceRequest $request, Source $source){
        
        $source = $this->services->save($request, $source);
        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $source->toArray(),
        ]);
    }

    public function destroy(Source $source){
        $source->delete();
        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $source->toArray(),
        ]);
    }
}
