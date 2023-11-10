<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ElectionService;
use Livewire\Attributes\Layout;

class PastElection extends Component
{
    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.past-election', [
            'past_elections' => (new ElectionService)->getPastElections(),
        ]);
    }
}
