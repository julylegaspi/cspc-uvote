<?php

namespace App\Livewire\OrganizationResource;

use Livewire\Component;
use App\Models\Organization;
use Livewire\WithPagination;

class ListOrganizations extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function destroy(Organization $organization)
    {
        activity()->log("deleted Organization {$organization->name}.");
        $organization->delete();

        session()->flash('success', 'Organization deleted.');

        $this->redirect(ListOrganizations::class);
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
