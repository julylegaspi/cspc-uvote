<?php

namespace App\Livewire\ElectionResource;

use Livewire\Component;
use App\Models\Election;
use Livewire\WithPagination;
use App\Services\ElectionService;
use Illuminate\Http\RedirectResponse;

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
        if ( (new ElectionService)->electionHasEnded($election) )
        {
            abort(403, 'Unable to delete. Election has ended.');
        }
        
        activity()->log("delete Election {$election->id}");
        $election->delete();

        session()->flash('success', 'Election deleted.');

        $this->redirect(ListElections::class);
    }

    public function render()
    {
        activity()->log('viewed Elections.');
        $elections = Election::with('organization')
                ->where('organization_id', 'like', '%'.$this->query.'%')
                ->orWhere('start', 'like', '%'.$this->query.'%')
                ->orWhere('end', 'like', '%'.$this->query.'%')
                ->orderBy('start', 'desc')
                ->paginate(10);

        return view('livewire.election-resource.list-elections', [
            'elections' => $elections,
        ]);
    }
}
