<?php

namespace App\Livewire;

use App\Models\Faq as F;
use Livewire\Component;

class Faq extends Component
{
    public function render()
    {
        $faqs = F::orderBy('id', 'desc')->get();
        return view('livewire.faq', compact('faqs'));
    }
}
