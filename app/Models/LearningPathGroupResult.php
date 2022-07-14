<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningPathGroupResult extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'submited_at',
        'score',
        'learning_path_group_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'learning_path_group_results';

    protected $casts = [
        'submited_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function learningPathGroup()
    {
        return $this->belongsTo(LearningPathGroup::class);
    }
}
