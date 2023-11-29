<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use App\Models\Partylist;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RelationshipExport implements  FromQuery, WithTitle, WithHeadings
{
    private $relationship;

    public function __construct($relationship)
    {
        $this->relationship = $relationship;
    }

    public function query()
    {
        if ($this->relationship == 'Course')
        {
            return Course::query()->select('id', 'name');
        }
        if ($this->relationship == 'Section')
        {
            return Section::query()->select('id', 'level', 'name');
        }
        if ($this->relationship == 'Partylist')
        {
            return Partylist::query()->select('id', 'name');
        }

        return collect([]);
    }

    public function headings(): array
    {
        if (in_array($this->relationship, ['Course', 'Partylist']))
        {
            return ["ID", "Name"];
        }

        if ($this->relationship === 'Section')
        {
            return ["ID", "Level", "Name"];
        }

        return ['Name', 'Email', 'Student_id', 'Course_id', 'Section_id', 'Partylist_id', 'Address', 'Organizational_affiliation', 'Notable_achievements', 'Platform'];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->relationship;
    }
}
