<?php

namespace App\Livewire\PartylistResource;

use Livewire\Component;
use App\Models\Partylist;
use Livewire\WithPagination;

class ListPartylists extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function destroy(Partylist $partylist)
    {
        activity()->log("deleted Partylist {$partylist->name}.");
        $partylist->delete();

        session()->flash('success', 'Partylist deleted.');

        $this->redirect(ListPartylists::class);
    }
    
    public function render()
    {
        activity()->log("viewed Partylists.");
        $partylists = Partylist::where('code', 'like', '%'.$this->query.'%')
                ->orWhere('name', 'like', '%'.$this->query.'%')
                ->paginate(10);
        return view('livewire.partylist-resource.list-partylists', [
            'partylists' => $partylists
        ]);
    }
}
