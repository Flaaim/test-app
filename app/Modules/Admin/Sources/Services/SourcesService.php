<?php

namespace App\Modules\Admin\Sources\Services;

use App\Modules\Admin\Sources\Models\Source;

class SourcesService {
    public function getSources(){
        return Source::all();
    }

    public function save($request, $source){
        $source->fill($request->only($source->getFillable()));
        $source->save();
        return $source;
    }
}
