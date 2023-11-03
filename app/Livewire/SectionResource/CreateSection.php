<?php

namespace App\Livewire\SectionResource;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use Livewire\Attributes\Rule;

class CreateSection extends Component
{
    #[Rule('required|integer')]
    public $course;

    #[Rule('required|integer')]
    public $level;

    #[Rule('required|string')]
    public $name;

    public function save()
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

    public function render()
    {
        $courses = Course::orderBy('name', 'asc')->get();
        return view('livewire.section-resource.create-section', [
            'courses' => $courses
        ]);
    }
}
