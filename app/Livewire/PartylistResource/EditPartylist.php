<?php

namespace App\Livewire\PartylistResource;

use Livewire\Component;
use App\Models\Partylist;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class EditPartylist extends Component
{
    use WithFileUploads;

    public Partylist $partylist;
    
    public $code;
    public $name;
    public $photo;

    protected function rules()
    {
        return [
            'code' => 'required|string',
            'name' => 'required|string',
            'photo' => 'nullable|image|max:1024'
        ];
    }

    public function mount(Partylist $partylist)
    {
        $this->partylist = $partylist;
        $this->code = $partylist->code;
        $this->name = $partylist->name;
    }

    public function update()
    {
        $this->validate();
        activity()->log("updated Partylist.");

        $this->partylist->code = $this->code;
        $this->partylist->name = $this->name;

       $photo = $this->partylist->photo;

        if($this->photo)
        {
            $imageName = Str::random() . '.' . $this->photo->getClientOriginalExtension();
            $photo = $this->photo->storeAs('partylist-photo', $imageName);
        }
        $this->partylist->photo = $photo;
        $this->partylist->save();

        session()->flash('success', 'Partylist updated.');

        $this->redirect(ListPartylists::class);
    }
    
    public function render()
    {
        return view('livewire.partylist-resource.edit-partylist');
    }
}
