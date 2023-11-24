<?php

namespace App\Livewire\DepartmentResource;

use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class ListDepartments extends Component
{
    use WithPagination;

    public Department $department;

    public $query = '';

    #[Rule('required|string')]
    public $code = "";

    #[Rule('required|string')]
    public $name = "";

    public function search()
    {
        $this->resetPage();
    }
    
    public function store()
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

    public function edit(Department $department)
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

    public function destroy(Department $department)
    {
        activity()->log("deleted Department {$department->name}.");
        $department->delete();

        session()->flash('success', 'Department deleted.');
        $this->redirect(ListDepartments::class);
    }

    public function cancel()
    {
        $this->code = "";
        $this->name = "";
        $this->resetValidation();
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
