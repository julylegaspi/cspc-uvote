<?php

namespace App\Livewire\OrganizationResource;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Organization;
use Livewire\WithFileUploads;

class CreateOrganization extends Component
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

    public function render()
    {
        return view('livewire.organization-resource.create-organization');
    }
}
