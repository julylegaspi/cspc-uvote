<?php

namespace App\Livewire\UserResource;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use App\Models\Partylist;

class CreateUser extends Component
{
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

    public function save()
    {
        
    }

    public function render()
    {
        $courses = Course::orderBy('name', 'asc')->get();
        $sections = Section::orderBy('name', 'asc')->get();
        $partylists = Partylist::orderBy('name', 'asc')->get();
        return view('livewire.user-resource.create-user', [
            'courses' => $courses,
            'sections' => $sections,
            'partylists' => $partylists,
        ]);
    }
}
