<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizResult extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['quiz_id', 'user_id', 'submited_at', 'result'];

    protected $searchableFields = ['*'];

    protected $table = 'quiz_results';

    protected $casts = [
        'submited_at' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
