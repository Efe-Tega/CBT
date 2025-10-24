<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRecordScore extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function term()
    {
        return $this->belongsTo(AcademicTerm::class, 'term_id');
    }

    public function year()
    {
        return $this->belongsTo(AcademicYear::class, 'year_id');
    }
}
