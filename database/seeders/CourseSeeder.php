<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            'department_id' => 1,
            'code' => 'BSIT',
            'name' => 'Bachelor of Science in Information Technology',
            'year_count' => 4
        ]);
    }
}
