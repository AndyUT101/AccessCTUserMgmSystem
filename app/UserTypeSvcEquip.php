<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTypeSvcEquip extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_type_id', 'svc_equip_id',
        'accept_notify', 'approve_right',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user_type()
    {
        return $this->belongsTo('App\UserType', 'user_type_id')->withDefault();
    }

    public function svc_equip()
    {
        return $this->belongsTo('App\SvcEquip', 'svc_equip_id')->withDefault();
    }
}
