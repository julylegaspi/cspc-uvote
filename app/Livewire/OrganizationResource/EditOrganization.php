<?php

namespace App\Livewire\OrganizationResource;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Organization;
use Livewire\WithFileUploads;

class EditOrganization extends Component
{
    use WithFileUploads;

    public Organization $organization;
    
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

    public function mount(Organization $organization)
    {
        $this->organization = $organization;
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
    
    public function render()
    {
        return view('livewire.organization-resource.edit-organization');
    }
}
