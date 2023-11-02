<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Election;
use Livewire\Attributes\Layout;

class ThankYouMessage extends Component
{
    public Election $election;

    public function mount(Election $election): void
    {
        $this->election = $election;
    }

    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.thank-you-message');
    }
}
