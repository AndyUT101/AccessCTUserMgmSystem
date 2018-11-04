<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcEquipItems extends Model
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
    public function access_statuses()
    {
        return $this->hasMany('App\AccessStatus', 'svcequipitem_id');
    }

    public function svc_equip()
    {
        return $this->belongsTo('App\SvcEquip', 'svc_equip_id')->withDefault();
    }

    public function svc_equip_category()
    {
        return $this->belongsTo('App\SvcEquipCategory', 'item_category_id')->withDefault();
    }
}
