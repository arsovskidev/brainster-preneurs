<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academies()
    {
        return $this->belongsToMany(Academy::class);
    }

    public function applications()
    {
        return $this->belongsToMany(User::class, 'applications', 'project_id', 'user_id')->withPivot('status', 'message');
    }
}
