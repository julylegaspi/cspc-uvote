<?php

namespace App\Livewire\PositionResource;

use Livewire\Component;
use App\Models\Position;
use Livewire\WithPagination;

class ListPositions extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function destroy(Position $position)
    {
        $position->delete();

        session()->flash('success', 'Position deleted.');

        $this->redirect(ListPositions::class);
    }
    
    public function render()
    {
        $positions = Position::where('name', 'like', '%'.$this->query.'%')
                ->paginate(10);
        return view('livewire.position-resource.list-positions', [
            'positions' => $positions
        ]);
    }
}
