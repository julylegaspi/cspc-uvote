<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    use WithPagination;


    public function render()
    {
        $logs = Activity::with('causer')->orderBy('id', 'desc')->paginate(10);
        return view('livewire.activity-log', [
            'logs' => $logs
        ]);
    }
}
