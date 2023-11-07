<?php

namespace App\Livewire\DepartmentResource;

use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;

class ListDepartments extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function destroy(Department $department)
    {
        activity()->log("deleted Department {$department->name}.");
        $department->delete();

        session()->flash('success', 'Department deleted.');

        $this->redirect(ListDepartments::class);
    }
    
    public function render()
    {
        activity()->log("viewed Departments.");
        $departments = Department::where('code', 'like', '%'.$this->query.'%')
                ->orWhere('name', 'like', '%'.$this->query.'%')
                ->paginate(10);
        return view('livewire.department-resource.list-departments', [
            'departments' => $departments
        ]);
    }
}
