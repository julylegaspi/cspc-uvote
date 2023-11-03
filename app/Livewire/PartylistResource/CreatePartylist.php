<?php

namespace App\Livewire\PartylistResource;

use Livewire\Component;
use App\Models\Partylist;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class CreatePartylist extends Component
{
    use WithFileUploads;
    
    #[Rule('required|string')]
    public $code;

    #[Rule('required|string')]
    public $name;

    #[Rule('image|max:1024')]
    public $photo;

    public function save()
    {
        $this->validate();

        $photo =  $this->photo->store('partylist-photo');

        Partylist::create([
            'code' => $this->code,
            'name' => $this->name,
            'photo' => $photo,
            'color' => '#823431',
        ]);

        session()->flash('success', 'Partylist created.');

        $this->redirect(ListPartylists::class);
    }
    
    public function render()
    {
        return view('livewire.partylist-resource.create-partylist');
    }
}
