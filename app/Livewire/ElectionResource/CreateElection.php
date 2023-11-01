<?php

namespace App\Livewire\ElectionResource;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Election;
use App\Models\Position;
use App\Models\PartyList;
use App\Models\Organization;

class CreateElection extends Component
{
    public $organization = "";
    public $start_date;
    public $end_date = "";
    public $partylist = [];
    public $course = [];

    public $candidates = [];

    protected $rules = [
        'organization' => 'required',
        'start_date' => 'required|date|after_or_equal:now',
        'end_date' => 'required|date|after_or_equal:start_date',
        'partylist' => 'required',
        'candidates.*.candidates.*.position' => 'required',
        'candidates.*.candidates.*.user' => 'required'
    ];

    protected $messages = [
        'candidates.*.candidates.*.position' => 'Please select position.',
        'candidates.*.candidates.*.user' => 'Please select candidate.'
    ];

    public function save()
    {
        $data = $this->validate();

        $election = Election::create([
            'organization_id' => $data['organization'],
            'start' => $data['start_date'],
            'end' => $data['end_date'],
        ]);

        $election->courses()->attach($this->course);
        $election->partylists()->attach($this->partylist);
        
        foreach ($this->candidates as $partylistKey => $candidateValue) {
            foreach ($candidateValue['candidates'] as $candidate) {
                $election->candidates()->create([
                    'partylist_id' => $partylistKey,
                    'position_id' => $candidate['position'],
                    'user_id' => $candidate['user']
                ]);
            }
        }

        session()->flash('success', 'Election created.');

        $this->redirect(ListElections::class);
    }

    public function getPartylist()
    {
        foreach ($this->partylist as $partylist) {
            if (!in_array($partylist, array_column($this->candidates, 'partylist_id'), true))
            {
                $this->candidates[$partylist] = [
                    'partylist_id' => $partylist,
                    'partylist_name' => PartyList::find($partylist)->name,
                    'candidates' => [
                        [
                            'position' => '',
                            'user' => ''
                        ]
                    ],
                ];
            }

        }

        foreach ($this->candidates as $key => $value) {
            if (!in_array($key, $this->partylist))
            {
                unset($this->candidates[$key]);
            }
        }
    }

    public function addCandidate($key)
    {
        array_push($this->candidates[$key]['candidates'], [
            'position' => '',
            'user' => ''
        ]);

    }

    public function removeCandidate($partylist_id, $candidates_id)
    {
        unset($this->candidates[$partylist_id]['candidates'][$candidates_id]);
    }

    public function render()
    {
        $courses = Course::with('department')->get();
        $organizations = Organization::orderBy('name', 'asc')->get();
        $partylists = PartyList::orderBy('name', 'asc')->get();
        $positions = Position::orderBy('id', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();
        
        return view('livewire.election-resource.create-election', [
            'courses' => $courses,
            'organizations' => $organizations,
            'partylists' => $partylists,
            'positions' => $positions,
            'users' => $users,
        ]);
    }
}
