<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ElectionService;
use Livewire\Attributes\Layout;

class UpcomingElection extends Component
{
    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.upcoming-election', [
            'upcoming_elections' => (new ElectionService)->getUpcomingElections()
        ]);
    }
}
