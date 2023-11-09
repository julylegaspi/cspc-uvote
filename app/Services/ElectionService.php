<?php

namespace App\Services;

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

    public function getPartialResults()
    {

    }

    public function getFinalResults()
    {

    }

    public function getSummaryResults()
    {

    }

    public function electionHasEnded(Election $election)
    {
        return ($election->end < $this->currentDateTime) ? true : false;
    }

}