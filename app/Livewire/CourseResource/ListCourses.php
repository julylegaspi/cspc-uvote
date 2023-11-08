<?php

namespace App\Livewire\CourseResource;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class ListCourses extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function destroy(Course $course)
    {
        activity()->log("deleted Course.");
        $course->delete();

        session()->flash('success', 'Course deleted.');

        $this->redirect(ListCourses::class);
    }
    
    public function render()
    {
        activity()->log("viewed Courses.");
        $courses = Course::where('code', 'like', '%'.$this->query.'%')
                ->orWhere('name', 'like', '%'.$this->query.'%')
                ->with('department')
                ->paginate(10);
        return view('livewire.course-resource.list-courses', [
            'courses' => $courses,
        ]);
    }
}
