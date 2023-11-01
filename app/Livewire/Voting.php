<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Vote;
use Livewire\Component;
use App\Models\Election;
use App\Models\Position;
use Livewire\Attributes\Layout;

class Voting extends Component
{
    public Election $election;

    public $partylist;
    public $name;
    public $address;
    public $birthday;
    public $course;
    public $section;
    public $organizational_affiliation;
    public $notable_achievements;
    public $platform;

    public $readyToLoad = false;

    public function loadElection(): void
    {
        $this->readyToLoad = true;
    }

    public function mount(Election $election)
    {
        // abort if voted 
        if ($this->checkIfVoted($election))
        {
            abort(403, 'You have already cast your vote in this election.');
        }

        $currentDateTime = now()->format('Y-m-d H:i:s');

        $present = $election->where('start', '<=', $currentDateTime)->where('end', '>=', $currentDateTime)->first();
        
        // abort if not present election
        if (!$present)
        {
            abort(403);
        }

        $course = $election->courses->where('id', auth()->user()->course_id)->first();
        
        // abort if course is not belong to the voter
        if ($course === null)
        {
            abort(403);
        }

        $this->election = $election;

    }

    public function getCandidates()
    {
        return $this->election->candidates->groupBy('position.name');
    }

    public function getProfileInfo(User $user): void
    {
        $this->partylist = $user->partylist->name;
        $this->name = $user->name;
        $this->address = $user->address;
        $this->birthday = $user->birthday;
        $this->course = $user->course->name;
        $this->section = $user->section->name;
        $this->organizational_affiliation = $user->organizational_affiliation;
        $this->notable_achievements = $user->notable_achievements;
        $this->platform = $user->platform;
    }

    public function checkIfVoted(Election $election)
    {
        $vote = Vote::where('election_id', $election->id)->where('user_id', auth()->user()->id)->first();

        return $vote;
    }

    public function cancel()
    {
        $this->partylist = "";
        $this->name = "";
        $this->address = "";
        $this->birthday = "";
        $this->course = "";
        $this->section = "";
        $this->organizational_affiliation = "";
        $this->notable_achievements = "";
        $this->platform = "";
    }

    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.voting', [
            'candidates' => $this->getCandidates(),
        ]);
    }
}
