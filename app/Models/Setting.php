<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['key', 'value'];

    protected $searchableFields = ['*'];

    public static function maxStorageSize()
    {
        $setting = Setting::select('value')->where('key', '=', 'maxStorageSize')->get()->first();

        if(!$setting) {
            return 10737418240;
            // 10GBS EM BYTES //
        }

        return $setting->value;
    }
}
