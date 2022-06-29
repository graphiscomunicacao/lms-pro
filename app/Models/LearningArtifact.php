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

    public static function formatSize($size)
    {
        if ($size == 0) {
            return "-";
        } else {
            $units = [' Bs', ' kBs', ' MBs', ' GBs'];
            for ($i = 0; $size > 1024; $i++) $size /= 1024;
            return round($size , 2) . $units[$i];
        }
    }

    public static function calculatePercentage($number, $total)
    {
        $count1 = $number / $total;
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);
        return $count;
    }

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
