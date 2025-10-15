<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function exam()
    {
        return $this->hasMany(Exam::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
