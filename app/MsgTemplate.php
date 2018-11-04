<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsgTemplate extends Model
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
    public function user_msgs()
    {
        return $this->hasMany('App\MsgTemplate', 'msgtpl_id');
    }

    public function push_msgs()
    {
        return $this->hasMany('App\PushMsg', 'msgtpl_id');
    }
}
