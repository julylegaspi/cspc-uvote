<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Election;
use App\Services\ElectionService;
use Livewire\Attributes\Layout;

class ElectionResult extends Component
{
    public Election $election;

    public $currentDateTime;

    public $total_voter_counts = 0;

    public $total_users_voted = 0;

    public function mount(Election $election): void
    {
        $this->election = $election;

        $this->currentDateTime = now()->format('Y-m-d H:i:s');

        $courses = $this->election->courses->pluck('id');

        $this->total_voter_counts = User::whereIn('course_id', $courses)->count();

        $this->total_users_voted = $this->election->votes->groupBy('user.id')->count();
    }

    public function getVotePercentage()
    {
       return (new ElectionService)->getVotePercentage($this->election);
    }

    public function electionHasEnded()
    {
        return (new ElectionService)->electionHasEnded($this->election);
    }


    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.election-result', [
            'votePercentage' => $this->getVotePercentage(),
            'electionHasEnded' => $this->electionHasEnded(),
            'candidates' => (new ElectionService)->getResults($this->election),
        ]);
    }
}
