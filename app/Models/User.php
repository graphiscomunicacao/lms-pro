<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasApiTokens;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'total_experience',
        'password',
        'role_id',
        'job_id',
        'group_id',
        'manager_id',
        'profile_photo_path'
    ];

    protected $searchableFields = ['*'];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = "1234";
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function objectiveAnswers()
    {
        return $this->hasMany(ObjectiveAnswer::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function experienceDetails()
    {
        return $this->hasMany(ExperienceDetail::class);
    }

    public function learningPathGroupResults()
    {
        return $this->hasMany(LearningPathGroupResult::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function learningPaths()
    {
        return $this->belongsToMany(LearningPath::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class);
    }

    public function isSuperAdmin()
    {
        return in_array($this->email, config('auth.super_admins'));
    }
}
