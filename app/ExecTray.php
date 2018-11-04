<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExecTray extends Model
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
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->withDefault();
    }

    public function access_status()
    {
        return $this->belongsTo('App\AccessStatus', 'acsstatus_id')->withDefault();
    }
}
