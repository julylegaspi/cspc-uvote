<?php

namespace App\Livewire\PositionResource;

use Livewire\Component;
use App\Models\Position;
use Livewire\Attributes\Rule;

class CreatePosition extends Component
{
    #[Rule('required|string')]
    public $name;

    public function save()
    {
        $this->validate();
        activity()->log("created Position {$this->name}.");

        Position::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Position created.');

        $this->redirect(ListPositions::class);
    }

    public function render()
    {
        return view('livewire.position-resource.create-position');
    }
}
