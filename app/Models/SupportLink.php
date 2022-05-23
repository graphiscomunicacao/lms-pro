<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportLink extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'url', 'same_tab', 'cover_path'];

    protected $searchableFields = ['*'];

    protected $table = 'support_links';

    protected $casts = [
        'same_tab' => 'boolean',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}
