<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, Searchable, SoftDeletes;


    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    public static function averageUserPerGroup()
    {
        $groupsCount = Group::count();
        $groups = Group::all();

        if (!$groups || !$groupsCount) return 0;

        $totalUsers = 0;

        foreach ($groups as $group) {
            $userCount = User::where('group_id', '=', $group->id)->count();
            $totalUsers += $userCount;
        }

        return $totalUsers / $groupsCount;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
