<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'class_id',
        'registration_number',
        'gender',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class, 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            $year = date('y');

            // Fetch class name
            $className = strtoupper(DB::table('classes')
                ->where('id', $student->class_id)
                ->value('name'));

            // Get last registration number for this class & year
            $lastReg = DB::table('users')
                ->where('class_id', $student->class_id)
                ->where('registration_number', 'like', "NRS/$year/$className/%")
                ->orderBy('id', 'desc')
                ->value('registration_number');

            if ($lastReg) {
                $lastNumber = (int) substr($lastReg, strrpos($lastReg, '/') + 1);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $student->registration_number = "NRS/$year/$className/$newNumber";
        });
    }
}
