<?php

namespace App\Services;

use App\Models\User;
use App\Models\Election;

class ElectionService
{
    protected $currentDateTime;

    public function __construct()
    {
        $this->currentDateTime = now()->format('Y-m-d H:i:s');
    }

    public function getPresentElections()
    {
        $elections = Election::where('start', '<=', $this->currentDateTime)
            ->where('end', '>=', $this->currentDateTime)
            ->with('organization')
            ->latest()
            ->get();

        return $elections;
    }

    public function getUpcomingElections()
    {
        return Election::where('start', '>', $this->currentDateTime)->get();
    }

    public function getPastElections()
    {
        return Election::where('end', '<', $this->currentDateTime)->get();
    }

    public function getPartialResults(Election $election)
    {
        return $election->candidates->groupBy('position.name');
    }

    public function getResults(Election $election)
    {
        $candidate_lists = [];
        $candidates = $election->candidates->groupBy('position.name');

        foreach ($candidates as $positionName => $candidate) {
            foreach ($candidate as $c) {
                $count = $election->votes()->where('candidate_id', $c->user_id)->count();
                $candidate_lists[$positionName][] = [
                    'candidate' => User::find($c->user_id),
                    'count' => $count
                ];
            }
            usort($candidate_lists[$positionName], function($a, $b) {
                return $b['count'] <=> $a['count'];
            });
        }

        return $candidate_lists;
    }

    public function electionHasEnded(Election $election)
    {
        return ($election->end < $this->currentDateTime) ? true : false;
    }

    public function getVotePercentage(Election $election)
    {
        $courses = $election->courses->pluck('id');

        $total_voter_counts = User::whereIn('course_id', $courses)->count();

        $total_users_voted = $election->votes->groupBy('user.id')->count();

        return ($total_users_voted / $total_voter_counts) * 100;
    }

}