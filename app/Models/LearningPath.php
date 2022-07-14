<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningPath extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'cover_path',
        'start_time',
        'end_time',
        'availability_time',
        'tries',
        'passing_score',
        'approval_goal',
        'certificate_id',
        'experience_amount',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'learning_paths';

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function learningArtifacts()
    {
        return $this->belongsToMany(LearningArtifact::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function learningPathGroups()
    {
        return $this->belongsToMany(LearningPathGroup::class);
    }
}
