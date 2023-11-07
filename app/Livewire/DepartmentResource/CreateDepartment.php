<?php

namespace App\Livewire\DepartmentResource;

use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Rule;

class CreateDepartment extends Component
{
    #[Rule('required|string')]
    public $code = "";

    #[Rule('required|string')]
    public $name = "";
    
    public function save()
    {
        $this->validate();
        activity()->log("created Department {$this->name}.");

        Department::create([
            'code' => $this->code,
            'name' => $this->name
        ]);

        session()->flash('success', 'Department created.');

        $this->redirect(ListDepartments::class);
    }
    
    public function render()
    {
        return view('livewire.department-resource.create-department');
    }
}
