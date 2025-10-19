<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Authenticatable
{
    protected $guarded = [];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(Question::class, Subject::class);
    }
}
