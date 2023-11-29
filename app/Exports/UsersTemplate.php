<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersTemplate implements WithMultipleSheets
{
    use Exportable;

    protected $relationships;
    
    public function __construct(array $relationships)
    {
        $this->relationships = $relationships;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->relationships as $relationship) {
            
            $sheets[] = new RelationshipExport($relationship);
        }

        return $sheets;
    }

}
