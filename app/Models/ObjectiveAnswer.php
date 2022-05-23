<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObjectiveAnswer extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'objective_question_id',
        'objective_question_option_id',
        'is_correct',
        'time_spent',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'objective_answers';

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function objectiveQuestion()
    {
        return $this->belongsTo(ObjectiveQuestion::class);
    }

    public function objectiveQuestionOption()
    {
        return $this->belongsTo(ObjectiveQuestionOption::class);
    }
}
