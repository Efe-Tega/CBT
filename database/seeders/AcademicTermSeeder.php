<?php

namespace Database\Seeders;

use App\Models\AcademicTerm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $terms = [
            ['name' => 'First Term'],
            ['name' => 'Second Term'],
            ['name' => 'Third Term'],
        ];

        AcademicTerm::insert($terms);
    }
}
