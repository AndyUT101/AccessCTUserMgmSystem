<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcEquipCategory extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'keyname', 'name', 'desc',
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
        return $this->hasMany('App\SvcEquipItems', 'item_category_id');
    }
}
