<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExperienceDetail extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'experience_amount',
        'is_double',
        'type',
        'item_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'experience_details';

    protected $casts = [
        'is_double' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
