<?php

namespace App\Livewire\DepartmentResource;

use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Rule;

class EditDepartment extends Component
{
    public Department $department;

    #[Rule('required|string')]
    public $code = "";

    #[Rule('required|string')]
    public $name = "";

    public function mount(Department $department)
    {
        $this->department = $department;
        $this->code = $department->code;
        $this->name = $department->name;
    }

    public function update()
    {
        $this->validate();

        $this->department->code = $this->code;
        $this->department->name = $this->name;
        $this->department->save();

        session()->flash('success', 'Department updated.');

        $this->redirect(ListDepartments::class);
    }
    
    public function render()
    {
        return view('livewire.department-resource.edit-department');
    }
}
