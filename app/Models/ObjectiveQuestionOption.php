<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObjectiveQuestionOption extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['body', 'is_correct', 'objective_question_id'];

    protected $searchableFields = ['*'];

    protected $table = 'objective_question_options';

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function objectiveQuestion()
    {
        return $this->belongsTo(ObjectiveQuestion::class);
    }

    public function objectiveAnswers()
    {
        return $this->hasMany(ObjectiveAnswer::class);
    }
}
