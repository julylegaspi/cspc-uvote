<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ElectionService;
use Livewire\Attributes\Layout;

class HomePage extends Component
{
    public $readyToLoad = false;

    public function loadElections(): void
    {
        $this->readyToLoad = true;
    }

    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.home-page', [
            'present_elections' => $this->readyToLoad
                ? (new ElectionService)->getPresentElections()
                : [],
        ]);
    }
}
