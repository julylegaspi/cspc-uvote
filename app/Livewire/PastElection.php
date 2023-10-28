<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Election;

class PastElection extends Component
{
    public $currentDateTime;
    
    public function mount(): void
    {
        $this->currentDateTime = now()->format('Y-m-d H:i:s');
    }

    public function getPastElections()
    {
        return Election::where('end', '<', $this->currentDateTime)->get();
    }
    public function render()
    {
        return view('livewire.past-election', [
            'past_elections' => $this->getPastElections(),
        ]);
    }
}
