<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Election;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VoterConfirmation;
use Illuminate\Support\Facades\Mail;

class StoreVoteController extends Controller
{
    public function store(Request $request, Election $election)
    {
        $data = $request->except(['_token']);

        if (count($data) <= 0)
        {
            die('select at least one candidate');
        }

        if ($this->checkIfVoted($election))
        {
            abort(403, 'You have already cast your vote in this election.');
        }

        $reference_number = Str::uuid();
        foreach ($data as $key => $vote) {
            Vote::create([
                'election_id' => $election->id,
                'user_id' => auth()->user()->id,
                'position_id' => $key,
                'candidate_id' => $vote,
                'reference_number' => $reference_number
            ]);
        }

        

        $votes = Vote::where('user_id', auth()->user()->id)
            ->where('election_id', $election->id)
            ->get();

        //email user
        $mail_data = [
            'organization' => $election->organization->name,
            'voter' => auth()->user()->name,
            'reference_number' => $reference_number,
            'votes' => []
        ];

        $mail_data['organization'] = $election->organization->name;
        $mail_data['voter'] = auth()->user()->name;
        $mail_data['reference_number'] = $reference_number;

        foreach ($votes as $vote) {
            $mail_data['votes'][] = [
                'position' => $vote->position->name,
                'candidate' => $vote->candidate->name,
                'candidate_partylist' => $vote->candidate->party_list->name
            ];
        }

        Mail::to(auth()->user()->email)->send(new VoterConfirmation($mail_data));

        session()->flash('message', "Thank you for casting your vote.");
        return redirect('/');
    }

    public function checkIfVoted(Election $election)
    {
        $vote = Vote::where('election_id', $election->id)->where('user_id', auth()->user()->id)->first();

        return $vote;
    }
}
