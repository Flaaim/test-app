<?php

namespace App\Modules\Admin\Analitics\Service;

use Carbon\Carbon;
use DB;

class AnaliticsDataService 
{
    public function getAnalitics($request){
        $dateStart = Carbon::now();
       
        if($request->dateStart){
            $dateStart = Carbon::parse($request->dateStart);
        }
        if($request->dateEnd){
            $dateEnd = Carbon::parse($request->dateEnd);
        }
        $leadData = DB::select('CALL countLeads("'.$dateStart->format('Y-m-d').'","'.$dateEnd->format('Y-m-d').'")');
        
        return $leadData;
    }

}