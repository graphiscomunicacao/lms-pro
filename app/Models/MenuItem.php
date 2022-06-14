<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['menu_id', 'item_type', 'item_id', 'order'];

    protected $searchableFields = ['*'];

    protected $table = 'menu_items';

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
