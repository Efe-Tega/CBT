<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
