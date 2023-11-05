<?php

namespace App\Livewire\UserResource;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('success', 'User deleted.');

        $this->redirect(ListUsers::class);
    }
    
    public function render()
    {
        $users = User::where('name', 'like', '%'.$this->query.'%')
                ->orWhere('email', 'like', '%'.$this->query.'%')
                ->with('course', 'section')
                ->paginate(10);
        return view('livewire.user-resource.list-users', [
            'users' => $users
        ]);
    }
}
