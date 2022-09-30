<?php

namespace App\Modules\Admin\LeadComment\Model\Traits;

use App\Modules\Admin\Lead\Model\Lead;
use App\Modules\Admin\LeadComment\Model\LeadComment;

trait UserLeadsTrait {

    public function leads(){
        return $this->hasMany(Lead::class);
    }

    public function tasks(){

    }

    public function resposibleTasks(){
        
    }

    public function comments(){
        return $this->hasMany(LeadComment::class);
    }
}