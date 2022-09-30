<?php

namespace App\Modules\Admin\LeadComment\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Lead\Model\Lead;
use App\Modules\Admin\User\Model\User;
use App\Modules\Admin\Status\Model\Status;

class LeadComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'comment_value', 
    ];

    public function lead(){
        return $this->belongsTo(Lead::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function lastComment(){
        return $this->comments()->where('comments_value', '!=', NULL)->orderBy('id', 'desc')->first();
    }
}
