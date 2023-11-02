<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Election;
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
    }

    public function getVotePercentage()
    {
        $courses = $this->election->courses->pluck('id');

        $this->total_voter_counts = User::whereIn('course_id', $courses)->count();

        $this->total_users_voted = $this->election->votes->groupBy('user.id')->count();

        return ($this->total_users_voted / $this->total_voter_counts) * 100;
    }

    public function electionHasEnded()
    {
        return ($this->election->end < $this->currentDateTime) ? true : false;
    }

    public function getCandidates()
    {
        $candidate_lists = [];
        $candidates = $this->election->candidates->groupBy('position.name');

        // partial
        if (!$this->electionHasEnded())
        {
            return $this->election->candidates->groupBy('position.name');
        }

        //official
        foreach ($candidates as $positionName => $candidate) {
            $candidate_id = 0;
            $current_count = 0;
            foreach ($candidate as $c) {
                $count = $this->election->votes()->where('candidate_id', $c->user_id)->count();

                if ($count > $current_count)
                {
                    $candidate_id = $c->user_id;
                    $current_count = $count;
                }

            }

            $candidate_lists[$positionName] = [
                'candidate' => User::find($candidate_id),
                'count' => $current_count
            ];
        }

        return $candidate_lists;
    }

    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.election-result', [
            'votePercentage' => $this->getVotePercentage(),
            'electionHasEnded' => $this->electionHasEnded(),
            'candidates' => $this->getCandidates(),
        ]);
    }
}
