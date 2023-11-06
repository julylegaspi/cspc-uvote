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

class EditUser extends Component
{
    use WithFileUploads;
    
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
        $this->is_active = $user->is_active;
        $this->is_admin = $user->is_admin;
        $this->partylist = $user->partylist_id;
        $this->address = $user->address;
        $this->birthday = $user->birthday;
        $this->organizational_affiliation = $user->organizational_affiliation;
        $this->notable_achievements = $user->notable_achievements;
        $this->platform = $user->platform;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email:filter|unique:users,email,'.$this->user->id,
            'course' => 'required|integer',
            'section' => 'required|integer',
            'is_admin' => 'required|boolean',
            'photo' => 'nullable|image|max:1024',
        ];
    }

    protected $messages = [
        'is_admin' => 'The role field is required.'
    ];

    public function update()
    {
        $this->validate();

        $photo = $this->user->photo;
        if ($this->photo)
        {
            $imageName = Str::random() . '.' . $this->photo->getClientOriginalExtension();
            $photo = $this->photo->storeAs('user-photo', $imageName);
        }

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->student_id = $this->student_id;
        $this->user->course_id = $this->course;
        $this->user->section_id = $this->section;
        $this->user->gender = $this->gender;
        $this->user->photo = $photo;
        $this->user->is_admin = $this->is_admin;
        $this->user->partylist_id = $this->partylist;
        $this->user->address = $this->address;
        $this->user->birthday = $this->birthday;
        $this->user->organizational_affiliation = $this->organizational_affiliation;
        $this->user->notable_achievements = $this->notable_achievements;
        $this->user->platform = $this->platform;
        // if ($this->password)
        // {
        //     $this->user->password = Hash::make($this->password);
        // }
        $this->user->save();

        session()->flash('success', 'User updated.');

        $this->redirect(ListUsers::class);
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
