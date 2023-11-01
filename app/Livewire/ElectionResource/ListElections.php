<?php

namespace App\Livewire\ElectionResource;

use App\Models\Election;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\WithPagination;

class ListElections extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function destroy(Election $election)
    {
        $election->delete();

        session()->flash('success', 'Election deleted.');

        $this->redirect(ListElections::class);
    }

    public function render()
    {
        $elections = Election::with('organization')
                ->where('organization_id', 'like', '%'.$this->query.'%')
                ->orWhere('start', 'like', '%'.$this->query.'%')
                ->orWhere('end', 'like', '%'.$this->query.'%')
                ->paginate(10);

        return view('livewire.election-resource.list-elections', [
            'elections' => $elections,
        ]);
    }
}
