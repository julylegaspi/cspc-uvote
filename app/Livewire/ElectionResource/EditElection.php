<?php

namespace App\Livewire\ElectionResource;

use Livewire\Component;
use App\Models\Election;

class EditElection extends Component
{
    public Election $election;

    public function mount(Election $election): void
    {
        $this->election = $election;
    }
    
    public function render()
    {
        return view('livewire.election-resource.edit-election');
    }
}
