<?php

namespace App\Livewire\PartylistResource;

use Livewire\Component;
use App\Models\Partylist;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ListPartylists extends Component
{
    use WithPagination;

    use WithFileUploads;

    public Partylist $partylist;

    public $query = '';

    public $code;
    public $name;
    public $photo;

    public $logo;

    public function search()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'code' => 'required|string',
            'name' => 'required|string',
            'photo' => 'nullable|image|max:1024'
        ];
    }

    public function store()
    {
        $this->validate();
        activity()->log("created Partylist {$this->name}.");

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

    public function edit(Partylist $partylist)
    {
        $this->partylist = $partylist;
        if ($partylist->photo != null)
        {
            $this->logo = $partylist->photo;
        } else {
            $this->logo = null;
        }
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

    public function destroy(Partylist $partylist)
    {
        activity()->log("deleted Partylist {$partylist->name}.");
        $partylist->delete();

        session()->flash('success', 'Partylist deleted.');

        $this->redirect(ListPartylists::class);
    }
    
    public function cancel()
    {
        $this->code = "";
        $this->name = "";
        $this->photo = "";
        $this->partylist = new Partylist();
        $this->resetValidation();
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
