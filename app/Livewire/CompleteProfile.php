<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Section;
use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class CompleteProfile extends Component
{
    #[Rule('required|integer')]
    public $course;

    #[Rule('required|integer')]
    public $section;

    public $section_lists = [];

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

    public function getSections()
    {
        $this->section_lists = Section::where('course_id', $this->course)->get();
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
        $departments = Department::orderBy('name', 'asc')->with('courses')->get();
        return view('livewire.complete-profile', [
            'departments' => $departments,
        ]);
    }
}
