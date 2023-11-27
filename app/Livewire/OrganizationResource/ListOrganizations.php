<?php

namespace App\Livewire\OrganizationResource;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Organization;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ListOrganizations extends Component
{
    use WithPagination;
    
    use WithFileUploads;

    public Organization $organization;
    
    public $code;
    public $name;
    public $photo;

    public $logo;

    public $query = '';

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
        activity()->log("created Organization {$this->name}.");

        $photo = null;
        if ($this->photo)
        {
            $imageName = Str::random() . '.' . $this->photo->getClientOriginalExtension();
            $photo =  $this->photo->storeAs('organization-photo', $imageName);
        }

        Organization::create([
            'code' => $this->code,
            'name' => $this->name,
            'photo' => $photo,
        ]);

        session()->flash('success', 'Organization created.');

        $this->redirect(ListOrganizations::class);
    }

    public function edit(Organization $organization)
    {
        $this->organization = $organization;
        if ($organization->photo != null)
        {
            $this->logo = $organization->photo;
        } else {
            $this->logo = null;
        }
        $this->code = $organization->code;
        $this->name = $organization->name;
    }

    public function update()
    {
        $this->validate();
        activity()->log("updated Organization.");
        $this->organization->code = $this->code;
        $this->organization->name = $this->name;

        $photo = $this->organization->photo;
        if($this->photo)
        {
            $imageName = Str::random() . '.' . $this->photo->getClientOriginalExtension();
            $photo = $this->photo->storeAs('organization-photo', $imageName);
        }
        $this->organization->photo = $photo;
        $this->organization->save();

        session()->flash('success', 'Organizaiton updated.');

        $this->redirect(ListOrganizations::class);
    }

    public function destroy(Organization $organization)
    {
        activity()->log("deleted Organization {$organization->name}.");
        $organization->delete();

        session()->flash('success', 'Organization deleted.');

        $this->redirect(ListOrganizations::class);
    }

    public function cancel()
    {
        $this->code = "";
        $this->name = "";
        $this->photo = "";
        $this->organization = new Organization();
        $this->resetValidation();
    }
    
    public function render()
    {
        activity()->log("viewed Organizations.");
        $organizations = Organization::where('code', 'like', '%'.$this->query.'%')
                ->orWhere('name', 'like', '%'.$this->query.'%')
                ->paginate(10);
        return view('livewire.organization-resource.list-organizations', [
            'organizations' => $organizations
        ]);
    }
}
