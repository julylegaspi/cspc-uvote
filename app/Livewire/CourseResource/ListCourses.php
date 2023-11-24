<?php

namespace App\Livewire\CourseResource;

use App\Models\Course;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class ListCourses extends Component
{
    use WithPagination;

    public Course $course;

    public $query = '';

    public $filter_by_department = '';

    #[Rule('required|integer')]
    public $department = '';

    #[Rule('required|string')]
    public $code = "";

    #[Rule('required|string')]
    public $name = "";

    #[Rule('required|integer')]
    public $year_count = "";

    public function search()
    {
        $this->resetPage();
    }

    public function filterByDepartment()
    {
        $this->query = $this->filter_by_department;
    }

    public function resetFilterByDepartment()
    {
        $this->filter_by_department = "";
    }

    public function store()
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

    public function edit(Course $course)
    {
        $this->course = $course;
        $this->department = $course->department_id;
        $this->code = $course->code;
        $this->name = $course->name;
        $this->year_count = $course->year_count;
    }

    public function update()
    {
        $this->validate();

        $this->course->department_id = $this->department;
        $this->course->code = $this->code;
        $this->course->name = $this->name;
        $this->course->year_count = $this->year_count;
        $this->course->save();

        session()->flash('success', 'Course updated.');

        $this->redirect(ListCourses::class);
    }

    public function destroy(Course $course)
    {
        activity()->log("deleted Course.");
        $course->delete();

        session()->flash('success', 'Course deleted.');

        $this->redirect(ListCourses::class);
    }

    public function cancel()
    {
        $this->department = "";
        $this->code = "";
        $this->name = "";
        $this->year_count = "";
        $this->resetValidation();
    }
    
    public function render()
    {
        activity()->log("viewed Courses.");

        if (!empty($this->query))
        {
            $courses = Course::where('name', 'like', '%'.$this->query.'%')
                ->orWhere('code', 'like', '%'.$this->query.'%')
                ->paginate(10);
        } elseif(!empty($this->filter_by_department))
        {
            $courses = Course::where('department_id', $this->filter_by_department)
                    ->paginate(10);
        } else 
        {
            $courses = Course::orderBy('name', 'asc')
                    ->paginate(10);
        }

        $departments = Department::orderBy('name', 'asc')->get();
        return view('livewire.course-resource.list-courses', [
            'departments' => $departments,
            'courses' => $courses,
        ]);
    }
}
