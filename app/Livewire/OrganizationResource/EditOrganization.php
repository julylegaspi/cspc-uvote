<?php

namespace App\Livewire\OrganizationResource;

use Livewire\Component;
use App\Models\Organization;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class EditOrganization extends Component
{
    use WithFileUploads;

    public Organization $organization;
    
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

    public function mount(Organization $organization)
    {
        $this->organization = $organization;
        $this->code = $organization->code;
        $this->name = $organization->name;
    }

    public function update()
    {
        $this->validate();
        $this->organization->code = $this->code;
        $this->organization->name = $this->name;

        if ($this->removedLogo == 'yes')
        {
            if ($this->photo == null)
            {
                $this->addError('photo', 'The photo is required.');
                return false;
            }
            $photo = $this->photo->store('organization-photo');
            $this->organization->photo = $photo;
        }

        $this->organization->save();

        session()->flash('success', 'Organizaiton updated.');

        $this->redirect(ListOrganizations::class);
    }
    
    public function render()
    {
        return view('livewire.organization-resource.edit-organization');
    }
}
