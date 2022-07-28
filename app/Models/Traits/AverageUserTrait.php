<?php

namespace App\Models\Traits;

use App\Models\User;

trait AverageUserTrait
{
    public static function averageUserPerModel($data)
    {
        return number_format(
            User::where(substr($data->first()->table, 0, -1) . '_id', '!=', null)->count()
            / $data->count()
        );
    }
}
