<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'President',
            'Vice-President Internal Affair',
            'Vice-President External Affair',
            'Secretary',
            'Treasurer',
            'Public Resource Officer',
            'Auditor'
        ];

        foreach ($positions as $position) {
            DB::table('positions')->insert([
                'name' => $position,
            ]);
        }
    }
}
