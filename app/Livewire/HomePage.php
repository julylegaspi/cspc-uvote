<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Election;
use Livewire\Attributes\Layout;

class HomePage extends Component
{
    public $readyToLoad = false;

    public $currentDateTime;

    public function loadElections(): void
    {
        $this->readyToLoad = true;
    }

    public function mount(): void
    {
        $this->currentDateTime = now()->format('Y-m-d H:i:s');
    }

    public function getPresentElections()
    {
        $elections = Election::where('start', '<=', $this->currentDateTime)
            ->where('end', '>=', $this->currentDateTime)
            ->with('organization')
            ->latest()
            ->get();

        return $elections;
    }

    #[Layout('components.layouts.guest.app')]
    public function render()
    {

        return view('livewire.home-page', [
            'present_elections' => $this->readyToLoad
                ? $this->getPresentElections()
                : [],
        ]);
    }
}
