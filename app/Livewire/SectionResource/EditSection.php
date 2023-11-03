<?php

namespace App\Livewire\SectionResource;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use Livewire\Attributes\Rule;

class EditSection extends Component
{
    public Section $section;
    
    #[Rule('required|integer')]
    public $course;

    #[Rule('required|integer')]
    public $level;

    #[Rule('required|string')]
    public $name;

    public function mount(Section $section)
    {
        $this->section = $section;
        $this->course = $section->course_id;
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
    
    public function render()
    {
        $courses = Course::orderBy('name', 'asc')->get();
        return view('livewire.section-resource.edit-section', [
            'courses' => $courses
        ]);
    }
}
