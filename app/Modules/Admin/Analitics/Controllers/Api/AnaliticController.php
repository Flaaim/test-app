<?php

namespace App\Modules\Admin\Analitics\Controllers\Api;

use App\Modules\Admin\Analitics\Model\Analitic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Analitics\Service\AnaliticsDataService;
use App\Modules\Admin\Lead\Model\Lead;
use App\Services\Response\ResponseService;

class AnaliticController extends Controller
{
    protected $service;

    public function __construct(AnaliticsDataService $service){
        $this->service = $service;
    }

    public function index(Request $request){
        $this->authorize('viewAnalitics', Lead::class);
        $leadsData = $this->service->getAnalitics($request);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'items' => $leadsData,
        ]);
    }

}
