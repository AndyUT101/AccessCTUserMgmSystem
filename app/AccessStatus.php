<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessStatus extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'require_parameters',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['request_enddate', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'require_parameters' => 'array',
    ];

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
            case 5:
                return "Granted";
            default:
                return "Rejected";
        }
    }
}
