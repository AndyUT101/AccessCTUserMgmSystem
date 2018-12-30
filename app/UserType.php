<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'typelevel',
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
    public function users()
    {
        return $this->hasMany('App\User', 'usertype_id');
    }

    public function usertype_svcequip()
    {
        return $this->hasMany('App\UserTypeSvcEquip', 'user_type_id');
    }
}
