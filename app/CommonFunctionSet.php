<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\SvcEquipType;

class CommonFunctionSet extends Model
{
    public static function get_menuitem()
    {
        return SvcEquipType::All();
    }
}
