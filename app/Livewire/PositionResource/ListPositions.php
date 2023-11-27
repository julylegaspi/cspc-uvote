<?php

namespace App\Livewire\PositionResource;

use Livewire\Component;
use App\Models\Position;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class ListPositions extends Component
{
    use WithPagination;

    public Position $position;

    #[Rule('required|string')]
    public $name = '';

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function store()
    {
        $this->validate();
        activity()->log("created Position {$this->name}.");

        Position::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Position created.');

        $this->redirect(ListPositions::class);
    }

    public function edit(Position $position)
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

    public function destroy(Position $position)
    {
        activity()->log("deleted Position {$position->name}.");
        $position->delete();

        session()->flash('success', 'Position deleted.');

        $this->redirect(ListPositions::class);
    }

    public function cancel()
    {
        $this->name = "";
        $this->resetValidation();
    }
    
    public function render()
    {
        activity()->log("viewed Position.");
        $positions = Position::where('name', 'like', '%'.$this->query.'%')
                ->paginate(10);
        return view('livewire.position-resource.list-positions', [
            'positions' => $positions
        ]);
    }
}
