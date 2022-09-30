<?php

namespace App\Modules\Admin\LeadComment\Services;

use App\Modules\Admin\Lead\Model\Lead;
use App\Modules\Admin\User\Model\User;
use App\Modules\Admin\Status\Model\Status;
use App\Modules\Admin\Unit\Model\Unit;
use App\Modules\Admin\LeadComment\Model\LeadComment;

class LeadCommentService {


    public static function saveComment(string $text, Lead $lead, User $user, Status $status, string $commentValue = null, bool $is_event = false){
        $comment = new LeadComment([
            'text' => $text,
            'comment_value' => $commentValue,
        ]);
        $comment->is_event = $is_event;
        $comment->lead()->associate($lead)->user()->associate($user)->status()->associate($status)->save();

        return $comment;
    } 

    public function store($request, User $user){
        
        $lead = Lead::findOrFail($request->lead_id);
        $status = Status::findOrFail($request->status_id);
       
        if($status->id != $lead->status_id){
            $lead->status()->associate($status)->update();
            $is_event = true;
            $tmpText = "Пользователь: $user->firstname изменил статус лида $status->title_ru";
            self::saveComment($tmpText, $lead, $user, $status, $request->commentValue, $is_event);
            $lead->statuses()->attach($status->id);
        }
        
        if($request->user_id && $request->user_id != $lead->user_id){
            $newUser = User::findOrFail($request->user_id);
            $lead->user()->associate($newUser)->update();
            $is_event = true;
            $tmpText = "Пользователь: $user->firstname изменил автора лида $newUser->firstname";
            self::saveComment($tmpText, $lead, $user, $status, null, $is_event);
        }

        if($request->text){
            $tmpText = "Пользователь: $user->firstname оставил комментарий $request->text";
            self::saveComment($tmpText, $lead, $user, $status, $request->text);
        }
        return $lead;
        
    }
}