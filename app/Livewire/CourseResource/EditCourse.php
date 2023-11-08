<?php

namespace App\Livewire\CourseResource;

use App\Models\Course;
use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Rule;

class EditCourse extends Component
{
    public Course $course;

    #[Rule('required|integer')]
    public $department;

    #[Rule('required|string')]
    public $code;

    #[Rule('required|string')]
    public $name;

    #[Rule('required|integer')]
    public $year_count;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->department= $course->department->id;
        $this->code = $course->code;
        $this->name = $course->name;
        $this->year_count = $course->year_count;
    }

    public function update()
    {
        $this->validate();
        activity()->log("updated Course.");

        $this->course->department_id = $this->department;
        $this->course->code = $this->code;
        $this->course->name = $this->name;
        $this->course->year_count = $this->year_count;
        $this->course->save();

        session()->flash('success', 'Course updated.');

        $this->redirect(ListCourses::class);
    }

    public function render()
    {   
        $departments = Department::orderBy('name', 'asc')->get();
        return view('livewire.course-resource.edit-course', [
            'departments' => $departments
        ]);
    }
}
