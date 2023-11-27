<?php

namespace App\Livewire\SectionResource;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class ListSections extends Component
{
    use WithPagination;

    public $query = '';

    public Section $section;

    #[Rule('required|integer')]
    public $course = '';

    #[Rule('required|integer')]
    public $level = '';

    #[Rule('required|string')]
    public $name = '';

    public $year_count = '';

    public function getSections()
    {
        if(!empty($this->course))
        {
            $course = Course::find($this->course);
    
            $this->year_count = $course->year_count;
        } else {
            $this->year_count = '';
        }
    }

    public function search()
    {
        $this->resetPage();
    }

    public function store()
    {
        $this->validate();

        Section::create([
            'course_id' => $this->course,
            'level' => $this->level,
            'name' => $this->name
        ]);

        session()->flash('success', 'Section created.');

        $this->redirect(ListSections::class);
    }

    public function edit(Section $section)
    {
        $this->section = $section;
        $this->course = $section->course_id;
        $this->getSections();
        $this->level = $section->level;
        $this->name = $section->name;
    }

    public function update()
    {
        $this->validate();

        $this->section->course_id = $this->course;
        $this->section->level = $this->level;
        $this->section->name = $this->name;
        $this->section->save();

        session()->flash('success', 'Section updated.');

        $this->redirect(ListSections::class);
    }

    public function cancel()
    {
        // $this->course = "";
        // $this->level = "";
        // $this->name = "";
        $this->resetValidation();
    }

    public function destroy(Section $section)
    {
        $section->delete();

        session()->flash('success', 'Section deleted.');

        $this->redirect(ListSections::class);
    }
    
    public function render()
    {
        if (!empty($this->query))
        {
            $sections = Section::where('name', 'like', '%'.$this->query.'%')->get();
        } elseif (!empty($this->course)) {
            if ($this->level == '')
            {
                $this->level = 1;
            }
            $sections = Section::where('course_id', $this->course)
                        ->where('level', $this->level)
                        ->get();
        } else {
            $sections = Section::where('name', 'like', '%'.$this->query.'%')->get();
        }

        $departments = Department::with('courses')->get();
        $courses = Course::orderBy('name', 'asc')->get();
        return view('livewire.section-resource.list-sections', [
            'departments' => $departments,
            'courses' => $courses,
            'sections' => $sections,
        ]);
    }
}
