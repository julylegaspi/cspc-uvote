<?php

namespace App\Livewire\DepartmentResource;

use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class EditDepartment extends Component
{
    use WithPagination;
    
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
        activity()->log("update Department {$this->name}.");

        $this->department->code = $this->code;
        $this->department->name = $this->name;
        $this->department->save();

        session()->flash('success', 'Department updated.');

        $this->redirect(ListDepartments::class);
    }

    public function getDepartmentCourses()
    {
        return $this->department->courses()->paginate(10);
    }
    
    public function render()
    {
        activity()->log("edit Department {$this->name}.");

        return view('livewire.department-resource.edit-department', [
            'courses' => $this->getDepartmentCourses()
        ]);
    }
}
