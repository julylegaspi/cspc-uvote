<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Faq as F;
use Livewire\Attributes\Layout;

class Faq extends Component
{
    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        $faqs = F::orderBy('id', 'desc')->get();
        return view('livewire.faq', compact('faqs'));
    }
}
