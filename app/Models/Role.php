<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use App\Models\Traits\AverageUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, Searchable, SoftDeletes, AverageUserTrait;

    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
