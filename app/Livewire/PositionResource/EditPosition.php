<?php

namespace App\Livewire\PositionResource;

use Livewire\Component;
use App\Models\Position;
use Livewire\Attributes\Rule;

class EditPosition extends Component
{
    public Position $position;

    #[Rule('required|string')]
    public $name;

    public function mount(Position $position)
    {
        $this->position = $position;

        $this->name = $position->name;
    }

    public function update()
    {
        $this->validate();
        activity()->log("updated Position.");

        $this->position->name = $this->name;
        $this->position->save();

        session()->flash('success', 'Position updated.');

        $this->redirect(ListPositions::class);
    }
    
    public function render()
    {
        return view('livewire.position-resource.edit-position');
    }
}
