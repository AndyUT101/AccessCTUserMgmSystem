<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcEquip extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'keyname', 'name', 'desc', 'svc_equiptype_id',
    ];
    
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
    public function svc_equip_items()
    {
        return $this->hasMany('App\SvcEquipItems', 'svc_equip_id');
    }

    public function svc_equiptype()
    {
        return $this->belongsTo('App\SvcEquipType', 'svc_equiptype_id')->withDefault();
    }

    public function usertype_svcequip()
    {
        return $this->hasMany('App\UserTypeSvcEquip', 'svc_equip_id');
    }
}
