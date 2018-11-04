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
        return $this->belongsTo('App\SvcEquipItem', 'svcequipitem_id')->withDefault();
    }

    public function exec_trays()
    {
        return $this->hasMany('App\ExecTray', 'acsstatus_id');
    }
}
