<?php

namespace App\Livewire\PartylistResource;

use Livewire\Component;
use App\Models\Partylist;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class EditPartylist extends Component
{
    use WithFileUploads;

    public Partylist $partylist;
    
    #[Rule('required|string')]
    public $code;

    #[Rule('required|string')]
    public $name;

    #[Rule('image|max:1024')]
    public $photo;

    public $removedLogo = 'no';

    public function removeLogo()
    {
        $this->removedLogo = 'yes';
    }

    public function mount(Partylist $partylist)
    {
        $this->partylist = $partylist;
        $this->code = $partylist->code;
        $this->name = $partylist->name;
    }

    public function update()
    {
        
        $this->partylist->code = $this->code;
        $this->partylist->name = $this->name;

        if ($this->removedLogo == 'yes')
        {
            if ($this->photo == null)
            {
                $this->addError('photo', 'The photo is required.');
                return false;
            }
            $photo = $this->photo->store('partylist-photo');
            $this->partylist->photo = $photo;
        }

        $this->partylist->save();

        session()->flash('success', 'Organizaiton updated.');

        $this->redirect(ListPartylists::class);
    }
    
    public function render()
    {
        return view('livewire.partylist-resource.edit-partylist');
    }
}
