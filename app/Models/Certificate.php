<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'description', 'background_path'];

    protected $searchableFields = ['*'];

    public function learningPaths()
    {
        return $this->hasMany(LearningPath::class);
    }
}
