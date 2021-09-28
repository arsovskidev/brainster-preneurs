<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'biography',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function applications()
    {
        return $this->belongsToMany(Project::class, 'applications', 'user_id', 'project_id')->withPivot('status', 'message');
    }
}
