<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessStatus extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get associated fields
     * 
     * @return void
     */
    public function svc_equip_item()
    {
        return $this->belongsTo('App\SvcEquipItems', 'svcequipitem_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->withDefault();
    }

    public function exec_trays()
    {
        return $this->hasMany('App\ExecTray', 'acsstatus_id');
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) 
        {
            case 1:
                return "Active";
            case 2:
                return "Approved";
            default:
                return "Closed";
        }
    }
}
