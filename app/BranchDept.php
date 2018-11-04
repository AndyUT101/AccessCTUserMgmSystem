<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchDept extends Model
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
    public function users()
    {
        return $this->hasMany('App\User', 'branchdept_id');
    }

    public function zone()
    {
        return $this->belongsTo('App\Zone', 'zone_id')->withDefault();
    }
}
