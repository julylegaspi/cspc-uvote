<?php

namespace App\Livewire\UserResource;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use App\Models\Partylist;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Component
{
    use WithFileUploads;
    
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
    // public $password;

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email:filter|unique:users',
            'course' => 'required|integer',
            'section' => 'required|integer',
            'is_admin' => 'required|boolean',
            // 'password' => 'required',
            'photo' => 'nullable|image|max:1024'
        ];
    }

    protected $messages = [
        'is_admin' => 'The role field is required.'
    ];

    public function save()
    {
        $this->validate();

        $photo = null;
        if ($this->photo)
        {
            $imageName = Str::random() . '.' . $this->photo->getClientOriginalExtension();
            $photo = $this->photo->storeAs('user-photo', $imageName);
        }

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'student_id' => $this->student_id,
            'course_id' => $this->course,
            'section_id' => $this->section,
            'gender' => $this->gender,
            'photo' => $photo,
            'is_admin' => $this->is_admin,
            'partylist_id' => $this->partylist,
            'address' => $this->address,
            'birthday' => $this->birthday,
            'organizational_affiliation' => $this->organizational_affiliation,
            'notable_achievements' => $this->notable_achievements,
            'platform' => $this->platform,
            'password' => Hash::make('password'),
        ]);

        session()->flash('success', 'User created.');

        $this->redirect(ListUsers::class);
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
