<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
}
