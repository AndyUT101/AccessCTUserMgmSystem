<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMsg extends Model
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

    public function msg_template()
    {
        return $this->belongsTo('App\MsgTemplate', 'msgtpl_id')->withDefault();
    }
    
}
