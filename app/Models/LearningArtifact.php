<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningArtifact extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'size',
        'path',
        'description',
        'external',
        'url',
        'cover_path',
        'experience_amount',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'learning_artifacts';

    protected $casts = [
        'external' => 'boolean',
    ];

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

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }
}
