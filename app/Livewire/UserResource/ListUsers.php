<?php

namespace App\Livewire\UserResource;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use App\Models\Partylist;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Imports\UsersImport;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ListUsers extends Component
{
    use WithPagination;

    use WithFileUploads;

    public User $user;

    public $query = '';
    
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

    public $image;

    public $departments;
    public $courses;
    public $sections = [];
    public $partylists;

    public $import_file;

    public function mount()
    {
        $this->departments = Department::with('courses')->get();
        $this->partylists = Partylist::orderBy('name', 'asc')->get();
    }

    public function getSections()
    {
        if(!empty($this->course))
        {
            $this->sections = Section::where('course_id', $this->course)->orderBy('level', 'asc')->get();
        } else {
            $this->sections = '';
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email:filter',
            'is_admin' => 'required|boolean',
            // 'password' => 'required',
            'photo' => 'nullable|image|max:1024'
        ];
    }

    protected $messages = [
        'is_admin' => 'The role field is required.'
    ];

    public function search()
    {
        $this->resetPage();
    }

    public function store()
    {
        $this->validate();
        activity()->log("created User {$this->name}.");

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

    public function edit(User $user)
    {
        $this->user = $user;
        if ($user->photo != null)
        {
            $this->image = $user->photo;
        } else {
            $this->image = null;
        }

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

    public function update()
    {
        $this->validate();
        activity()->log("updated User.");

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

    public function destroy(User $user)
    {
        activity()->log("deleted User {$user->name}.");
        $user->delete();

        session()->flash('success', 'User deleted.');

        $this->redirect(ListUsers::class);
    }

    public function cancel()
    {
        $this->name = "";
        $this->email = "";
        $this->student_id = "";
        $this->course = "";
        $this->section = "";
        $this->gender = "";
        $this->photo = "";
        $this->is_active = "";
        $this->is_admin = "";
        $this->partylist = "";
        $this->address = "";
        $this->birthday = "";
        $this->organizational_affiliation = "";
        $this->notable_achievements = "";
        $this->platform = "";
        $this->resetValidation();
    }
    
    public function render()
    {
        activity()->log("viewed Users.");
        $users = User::where('name', 'like', '%'.$this->query.'%')
                ->orWhere('email', 'like', '%'.$this->query.'%')
                ->with('course', 'section')
                ->paginate(10);

        return view('livewire.user-resource.list-users', [
            'users' => $users,
        ]);
    }
}
