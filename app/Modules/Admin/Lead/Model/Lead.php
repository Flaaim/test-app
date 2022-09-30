<?php

namespace App\Modules\Admin\Lead\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\User\Model\User;
use App\Modules\Admin\Unit\Model\Unit;
use App\Modules\Admin\Status\Model\Status;
use App\Modules\Admin\Sources\Models\Source;

class Lead extends Model
{
    use HasFactory;

    const DONE_STATUS = 3;

    protected $fillable = [
        'link',
        'phone',
        'source_id',
        'unit_id',
        'is_processed',
        'is_express_delivery',
        'is_add_sale',
    ];

    public function source(){
        return $this->belongsTo(Source::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public function statuses(){
        return $this->belongsToMany(Status::class);
    }
    public function getLeads(){
        return $this->with(['source', 'unit', 'status'])->whereBetween('status_id', [1,2])->orWhere(
            [
                ['status_id', 3],
                ['updated_at', '>', \DB::raw('DATE_SUB(NOW(), INTERVAL 24 HOUR)')],
            ]
        )->orderBy('created_at')->get();
        
    }

    public function getArhive(){
        return $this->with(['statuses', 'source', 'unit'])->where('status_id', self::DONE_STATUS)
            ->where('updated_at', '<', \DB::raw('DATE_SUB(NOW(), INTERVAL 24 HOUR)'))
            ->orderBy('updated_at', 'DESC')->paginate(config('settings.pagination'));
    }

}
