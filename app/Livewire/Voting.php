<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Vote;
use Livewire\Component;
use App\Models\Election;
use Illuminate\Support\Str;
use App\Mail\VoterConfirmation;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Mail;

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

    public $votes = [];

    public $review = 'no';

    public $readyToLoad = false;

    public $voted_positions = [];

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
            abort(403, 'Election is not on-going.');
        }

        $course = $election->courses->where('id', auth()->user()->course_id)->first();
        
        // abort if course is not belong to the voter
        if ($course === null)
        {
            abort(403, 'Election is not belong to your course.');
        }

        $this->election = $election;

    }

    protected function rules()
    {
        return [
            'votes' => 'required'
        ];
    }

    protected $messages = [
        'votes.required' => 'Please select at least one candidate',
    ];

    public function showReview()
    {
        $this->review = 'yes';
        ksort($this->votes);
    }

    public function getCandidates()
    {
        return $this->election->candidates->groupBy('position.name');
    }

    public function getProfileInfo(User $user): void
    {
        $this->partylist = $user->partylist->name ?? 'No Partylist';
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

    public function submit()
    {
        $this->validate();
        
        $reference_number = Str::random(6) . '-' . Str::random(1) . '-' . Str::random(3);

        foreach ($this->votes as $positionKey => $candidate_id) {
            Vote::create([
                'election_id' => $this->election->id,
                'user_id' => auth()->user()->id,
                'position_id' => $positionKey,
                'candidate_id' => $candidate_id,
                'reference_number' => $reference_number
            ]);
        }

        $votes = Vote::where('user_id', auth()->user()->id)
            ->where('election_id', $this->election->id)
            ->get();

        //email user
        $mail_data = [
            'organization' => $this->election->organization->name,
            'voter' => auth()->user()->name,
            'reference_number' => $reference_number,
            'votes' => []
        ];

        $mail_data['organization'] = $this->election->organization->name;
        $mail_data['voter'] = auth()->user()->name;
        $mail_data['reference_number'] = $reference_number;

        foreach ($votes as $vote) {
            $mail_data['votes'][] = [
                'position' => $vote->position->name,
                'candidate' => $vote->candidate->name,
                'candidate_partylist' => $vote->candidate->partylist->name
            ];
        }

        Mail::to(auth()->user()->email)->send(new VoterConfirmation($mail_data));

        return redirect()->route('thank-you.index', $this->election);
    }

    public function toggleTabColor($position)
    {
        if(!in_array($position, $this->voted_positions))
        {
            array_push($this->voted_positions, $position);
        }
    }

    public function clearVotes()
    {
        $this->votes = [];
        $this->voted_positions = [];
    }

    #[Layout('components.layouts.guest.app')]
    public function render()
    {
        return view('livewire.voting', [
            'candidates' => $this->getCandidates(),
        ]);
    }
}
