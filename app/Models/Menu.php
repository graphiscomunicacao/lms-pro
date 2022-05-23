<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'description', 'cover_path'];

    protected $searchableFields = ['*'];

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function learningArtifacts()
    {
        return $this->belongsToMany(LearningArtifact::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }

    public function supportLinks()
    {
        return $this->belongsToMany(SupportLink::class);
    }
}
