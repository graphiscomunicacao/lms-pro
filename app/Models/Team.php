<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    public static function getBiggestTeam($data)
    {
        $pivot = array_key_first(
            DB::table('team_user')
            ->get()
            ->countBy('team_id')
            ->sortDesc()
            ->all()
        );

        if (!$pivot) return '-';

        return $data->where('id', '=', $pivot)->first()->name;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function learningPaths()
    {
        return $this->belongsToMany(LearningPath::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    public function learningArtifacts()
    {
        return $this->belongsToMany(LearningArtifact::class);
    }

    public function learningPathGroups()
    {
        return $this->belongsToMany(LearningPathGroup::class);
    }
}
