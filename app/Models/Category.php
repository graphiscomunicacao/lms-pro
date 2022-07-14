<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'cover_path'
    ];

    protected $searchableFields = ['*'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = (string) Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = (string) Str::slug($category->name);
        });
    }

    public function learningArtifacts()
    {
        return $this->belongsToMany(LearningArtifact::class);
    }

    public function supportLinks()
    {
        return $this->belongsToMany(SupportLink::class);
    }

    public function objectiveQuestions()
    {
        return $this->belongsToMany(ObjectiveQuestion::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }

    public function learningPaths()
    {
        return $this->belongsToMany(LearningPath::class);
    }
}
