<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class CompleteProfile extends Component
{
    #[Rule('required|integer')]
    public $course;

    #[Rule('required|integer')]
    public $section;

    public User $user;

    public function mount()
    {
        if (Auth::check())
        {
            $this->user = auth()->user();
            if ($this->user->course_id != null || $this->user->section_id != null)
            {
                abort(404);
            }
        }
    }

    public function save()
    {
        $this->validate();

        $this->user->update([
            'course_id' => $this->course,
            'section_id' => $this->section
        ]);
        
        session()->flash('success', 'Profile completed');

        $this->redirect(HomePage::class);
    }

    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        $courses = Course::orderBy('name', 'asc')->get();
        $sections = Section::orderBy('name', 'asc')->get();
        return view('livewire.complete-profile', [
            'courses' => $courses,
            'sections' => $sections,
        ]);
    }
}
