<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObjectiveQuestion extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['body', 'answer_explanation', 'multi_option'];

    protected $searchableFields = ['*'];

    protected $table = 'objective_questions';

    protected $casts = [
        'multi_option' => 'boolean',
    ];

    public function objectiveQuestionOptions()
    {
        return $this->hasMany(ObjectiveQuestionOption::class);
    }

    public function objectiveAnswers()
    {
        return $this->hasMany(ObjectiveAnswer::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }
}
