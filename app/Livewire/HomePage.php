<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Election;

class HomePage extends Component
{
    public $readyToLoad = false;

    public $currentDateTime;

    public function loadElections(): void
    {
        $this->readyToLoad = true;
    }

    public function mount(): void
    {
        $this->currentDateTime = now()->format('Y-m-d H:i:s');
    }

    public function getPresentElections()
    {
        $elections = Election::where('start', '<=', $this->currentDateTime)
            ->where('end', '>=', $this->currentDateTime)
            ->with('organization')
            ->get();

        $elections_data = [];
        $candidates_id = [];

        foreach ($elections as $election) {
            foreach ($election->candidates as $candidate) {
                array_push($candidates_id, $candidate['candidate_id']);
            }

            $partylists = User::whereIn('id', $candidates_id)->with('partylist')->get()->groupBy('partylist.name');
            

            $elections_data[] = [
                'election_id' => $election->id,
                'organization' => $election->organization,
                'partylists' => $partylists
            ];
        }

        return $elections_data;
    }

    public function render()
    {
        return view('livewire.home-page', [
            'present_elections' => $this->readyToLoad
                ? $this->getPresentElections()
                : [],
        ]);
    }
}
