<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Election;
use Livewire\Attributes\Layout;

class UpcomingElection extends Component
{
    public $currentDateTime;

    public function mount(): void
    {
        $this->currentDateTime = now()->format('Y-m-d H:i:s');
    }

    public function getUpcomingElections()
    {
        return Election::where('start', '>', $this->currentDateTime)->get();
    }

    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.upcoming-election', [
            'upcoming_elections' => $this->getUpcomingElections()
        ]);
    }
}
