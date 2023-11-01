<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Root User',
            'email' => 'root@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'course_id' => 1,
            'section_id' => 1,
            'gender' => 'm',
            'is_active' => true,
            'is_admin' => true,
            'partylist_id' => 1,
        ]);
    }
}
