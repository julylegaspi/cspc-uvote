<?php

namespace App\Livewire\OrganizationResource;

use Livewire\Component;
use App\Models\Organization;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class CreateOrganization extends Component
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

        $photo =  $this->photo->store('organization-photo');

        Organization::create([
            'code' => $this->code,
            'name' => $this->name,
            'photo' => $photo,
        ]);

        session()->flash('success', 'Organization created.');

        $this->redirect(ListOrganizations::class);
    }

    public function render()
    {
        return view('livewire.organization-resource.create-organization');
    }
}
