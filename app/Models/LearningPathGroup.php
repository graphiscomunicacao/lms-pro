<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningPathGroup extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'cover_path',
        'name',
        'description',
        'start_time',
        'end_time',
        'availability_time',
        'tries',
        'approval_goal',
        'passing_score',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'learning_path_groups';

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function learningPathGroupResults()
    {
        return $this->hasMany(LearningPathGroupResult::class);
    }

    public function learningPaths()
    {
        return $this->belongsToMany(LearningPath::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }
}
