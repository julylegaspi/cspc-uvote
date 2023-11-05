<?php

namespace App\Livewire\UserResource;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use App\Models\Partylist;

class EditUser extends Component
{
    public User $user;

    public $name;
    public $email;
    public $student_id;
    public $course;
    public $section;
    public $gender;
    public $photo;
    public $is_active;
    public $is_admin;
    public $partylist;
    public $address;
    public $birthday;
    public $organizational_affiliation;
    public $notable_achievements;
    public $platform;

    public function mount(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->student_id = $user->student_id;
        $this->course = $user->course_id;
        $this->section = $user->section_id;
        $this->gender = $user->gender;
        $this->photo = $user->photo;
        $this->is_active = $user->is_active;
        $this->is_admin = $user->is_admin;
        $this->partylist = $user->partylist_id;
        $this->address = $user->address;
        $this->birthday = $user->birthday;
        $this->organizational_affiliation = $user->organizational_affiliation;
        $this->notable_achievements = $user->notable_achievements;
        $this->platform = $user->platform;
    }

    public function update()
    {
        
    }

    public function render()
    {
        $courses = Course::orderBy('name', 'asc')->get();
        $sections = Section::orderBy('name', 'asc')->get();
        $partylists = Partylist::orderBy('name', 'asc')->get();
        return view('livewire.user-resource.edit-user', [
            'courses' => $courses,
            'sections' => $sections,
            'partylists' => $partylists,
        ]);
    }
}
