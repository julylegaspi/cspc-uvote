<?php

namespace App\Livewire\CourseResource;

use App\Models\Course;
use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Rule;

class CreateCourse extends Component
{
    #[Rule('required|integer')]
    public $department = "";

    #[Rule('required|string')]
    public $code = "";

    #[Rule('required|string')]
    public $name = "";

    #[Rule('required|integer')]
    public $year_count = "";

    public function save()
    {
        $this->validate();
        activity()->log("created Course {$this->name}.");

        Course::create([
            'department_id' => $this->department,
            'code' => $this->code,
            'name' => $this->name,
            'year_count' => $this->year_count
        ]);

        session()->flash('success', 'Course created.');

        $this->redirect(ListCourses::class);
    }

    public function render()
    {
        activity()->log("viewd Courses.");
        $departments = Department::orderBy('name', 'asc')->get();
        return view('livewire.course-resource.create-course', [
            'departments' => $departments
        ]);
    }
}
