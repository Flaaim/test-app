<?php

namespace App\Modules\Admin\Lead\Services;

use App\Modules\Admin\Lead\Model\Lead;
use App\Modules\Admin\Status\Model\Status;
use App\Modules\Admin\User\Model\User;
use App\Modules\Admin\User\Model\Unit;
use App\Modules\Admin\LeadComment\Services\LeadCommentService;

class LeadService {

    public function getLeads(){
        $leads = (new Lead())->getLeads();
        $statuses = Status::all();

        $resultLeads = [];
        $statuses->each(function($item, $key) use(&$resultLeads, $leads) {
            $collection = $leads->where('status_id', $item->id);
            $resultLeads[$item->title] = $collection->map(function($elem){
                return $elem;
            });
        });

        return $resultLeads;
    }

    public function store($request, User $user){
        $lead = new Lead();
        $lead->fill($request->only($lead->getFillable()));

        $status = Status::where('title', 'new')->first();
        $lead->status()->associate($status);
        $user->leads()->save($lead);

        // add Comments
        $this->addStoreComment($lead, $request, $user, $status);
        $lead->statuses()->attach($status->id);
        return $lead;
    }

    private function addStoreComment($lead, $request, $user, $status){
        $is_event = true;
        $tmpText = "Автор: $user->firstname создал лид со статусом $status->title_ru";
        LeadCommentService::saveComment($tmpText, $lead, $user, $status, null, $is_event);
        if($request->text){
            $is_event = false;
            $tmpText = "Пользователь: $user->firstname оставил комментарий $request->text";
            LeadCommentService::saveComment($tmpText, $lead, $user, $status, $request->text, $is_event);
        }
    }

    public function update($request, $user, $lead){
        $lead->count_create++;
        $tmp = clone $lead;
        $status = Status::where('title', 'new')->first();
        $lead->fill($request->only($lead->getFillable()));
        $lead->status()->associate($status);
        $lead->save();

        $this->addUpdateComments($lead, $request, $user, $status, $tmp);
        return $lead;
    }

    private function addUpdateComments($lead, $request, $user, $status, $tmp){
        if($request->text){
            $tmpText = "Пользователь $user->firstname оставил комментарий $request->text";
            LeadCommentService::saveComment($tmpText, $lead, $user, $status, $request->text);
        }

        if($tmp->source_id != $lead->source_id){
            $is_event = true; 
            $tmpText = "Пользователь $user->firstname  изменил источник на ".$lead->source->title;
            LeadCommentService::saveComment($tmpText, $lead, $user, $status, null, $is_event);
        }
        if($tmp->unit_id != $lead->unit_id){
            $is_event = true;
            $tmpText = "Пользователь $user->firstname изменил подразделение на ".$lead->unit->title;
            LeadCommentService::saveComment($tmpText, $lead, $user, $status, null, $is_event);
        }
        if($tmp->status_id != $lead->status_id){
            $is_event = true;
            $tmpText = "Пользователь $user->firsname изменил статус на ".$lead->status->title_ru;
            LeadCommentService::saveComment($tmpText, $lead, $user, $status, null, $is_event);
        }

        $is_event = true;
        $tmpText = "Автор $user->firstname создал лид со статусом ".$status->title_ru;
        LeadCommentService::saveComment($tmpText, $lead, $user, $status, null, $is_event);

        $lead->statuses()->attach($status->id);
        
    }

    public function arhive(){
        $leads = (new Lead())->getArhive();
        return $leads;
    }

    public function checkExists($request){
        $queryBuilder = Lead::select('*');
        
        if($request->link){
            $queryBuilder->where('link', $request->link);
        }
        elseif($request->phone){
            $queryBuilder->where('phone', $request->phone);
        }
        $queryBuilder->where('status_id', '!=', Lead::DONE_STATUS);
        return $queryBuilder->first();
    }

    public function isQualityLead($request, $lead){
        $lead->isQualityLead = true;
        $lead->save();
        return $lead;
    }
}