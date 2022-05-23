<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievement extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'description', 'image_path', 'requirements'];

    protected $searchableFields = ['*'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
