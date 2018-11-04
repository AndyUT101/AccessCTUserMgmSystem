<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'last_login'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'uuid', '2fa_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', '2fa_token',
    ];


//     /**
//      * Ecrypt the user's google_2fa secret.
//      *
//      * @param  string  $value
//      * @return string
//      */
//     public function set2fa_tokenAttribute($value)
//     {
//          $this->attributes['2fa_token'] = encrypt($value);
//     }

//     /**
//      * Decrypt the user's google_2fa secret.
//      *
//      * @param  string  $value
//      * @return string
//      */
//     public function get2fa_tokenAttribute($value)
//     {
//         return decrypt($value);
//     }

    /**
     * Get associated fields
     * 
     * @return void
     */
    public function branch_dept()
    {
        return $this->belongsTo('App\BranchDept', 'branchdept_id')->withDefault();
    }

    public function user_type()
    {
        return $this->belongsTo('App\UserType', 'usertype_id')->withDefault();
    }

    public function user_msgs()
    {
        return $this->hasMany('App\UserMsg', 'user_id');
    }

    public function exec_trays()
    {
        return $this->hasMany('App\ExecTray', 'user_id');
    }

    public function activities()
    {
        return $this->hasMany('App\Activity', 'user_id');
    }

    /**
     * Get the easy to read request date for the ticket.
     *
     * @return string
     */
    public function getLastLoginByAgoAttribute()
    {
        return ($this->last_login == null) ? "" : $this->last_login->diffForHumans();
    }
}
