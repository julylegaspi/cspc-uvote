<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class TermsAndCondition extends Component
{
    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.terms-and-condition');
    }
}
