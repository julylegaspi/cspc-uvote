<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make('password'),
            'student_id' => $row['student_id'],
            'course_id' => $row['course_id'],
            'section_id' => $row['section_id'],
            'is_active' => true,
            'is_admin' => false,
            'partylist_id' => $row['partylist_id'],
            'address' => $row['address'],
            // 'birthday' => $row['birthday'],
            'organizational_affiliation' => $row['organizational_affiliation'],
            'notable_achievements' => $row['notable_achievements'],
            'platform' => $row['platform']
        ]);
    }

    public function uniqueBy()
    {
        return 'email';
    }

    public function headingRow(): int
    {
        return 1;
    }
}
