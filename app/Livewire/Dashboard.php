<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\PartyList;
use App\Models\Department;
use App\Models\Organization;

class Dashboard extends Component
{
    public $department_count = 0;
    public $course_count = 0;
    public $organization_count = 0;
    public $partylist_count = 0;
    public $user_count = 0;
    
    public function mount(): void
    {
        $this->department_count = Department::count();
        $this->course_count = Course::count();
        $this->organization_count = Organization::count();
        $this->partylist_count = PartyList::count();
        $this->user_count = User::count();
    }

    public function render()
    {
        activity()->log("viewed Dashboard.");
        return view('livewire.dashboard');
    }
}
