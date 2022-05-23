<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'time_limit',
        'cover_path',
        'experience_amount',
    ];

    protected $searchableFields = ['*'];

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function objectiveQuestions()
    {
        return $this->belongsToMany(ObjectiveQuestion::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function learningPaths()
    {
        return $this->belongsToMany(LearningPath::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}
