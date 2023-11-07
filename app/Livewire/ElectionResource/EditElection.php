<?php

namespace App\Livewire\ElectionResource;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Election;
use App\Models\Position;
use App\Models\PartyList;
use App\Models\Organization;
use Illuminate\Support\Facades\Log;

class EditElection extends Component
{
    public Election $election;

    public $organization = "";
    public $start_date;
    public $end_date = "";
    public $partylist = [];
    public $course = [];

    public $candidates = [];

    public function mount(Election $election): void
    {
        $this->election = $election;

        $this->organization = $election->organization_id;
        $this->start_date = $election->start;
        $this->end_date = $election->end;

        foreach ($election->courses as $course) {
            array_push($this->course, $course->id);
        }

        foreach ($election->partylists as $partylist) {
            array_push($this->partylist, $partylist->id);
        }

        foreach ($election->partylists as $partylist) {
            $this->candidates[$partylist->id] = [
                'partylist_id' => $partylist->id,
                'partylist_name' => $partylist->name,
                'candidates' => []
            ];
        }

        foreach ($election->candidates as $candidate) {
            array_push($this->candidates[$candidate['partylist_id']]['candidates'], [
                'position' => $candidate['position_id'], 
                'user' => $candidate['user_id']
            ]);
        }
    }

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

    public function update()
    {
        $this->validate();
        activity()->log("update Election {$this->election->organization->name}");

        $this->election->organization_id = $this->organization;
        $this->election->start = $this->start_date;
        $this->election->end = $this->end_date;
        $this->election->save();

        $this->election->courses()->sync($this->course);
        $this->election->partylists()->sync($this->partylist);

        $this->election->candidates()->delete();
        foreach ($this->candidates as $partylistKey => $candidateValue) {
            foreach ($candidateValue['candidates'] as $candidate) {
                $this->election->candidates()->create([
                    'partylist_id' => $partylistKey,
                    'position_id' => $candidate['position'],
                    'user_id' => $candidate['user']
                ]);
            }
        }

        session()->flash('success', 'Election updated');
        
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

        return view('livewire.election-resource.edit-election', [
            'courses' => $courses,
            'organizations' => $organizations,
            'partylists' => $partylists,
            'positions' => $positions,
            'users' => $users,
        ]);
    }
}
