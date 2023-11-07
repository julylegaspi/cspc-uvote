<?php

namespace App\Livewire\PartylistResource;

use Livewire\Component;
use App\Models\Partylist;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class CreatePartylist extends Component
{
    use WithFileUploads;
    
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

    public function save()
    {
        $this->validate();

        $photo = null;
        if ($this->photo)
        {
            $imageName = Str::random() . '.' . $this->photo->getClientOriginalExtension();
            $photo =  $this->photo->storeAs('partylist-photo', $imageName);
        }

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
