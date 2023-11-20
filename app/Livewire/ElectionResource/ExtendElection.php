<?php

namespace App\Livewire\ElectionResource;

use Livewire\Component;
use App\Models\Election;

class ExtendElection extends Component
{
    public Election $election;

    public $start_date;
    public $end_date;

    public function mount(Election $election)
    {
        $this->election = $election;
        $this->start_date = $election->start;
        $this->end_date = $election->end;
    }

    public function rules()
    {
        return [
            'end_date' => 'required|date|after_or_equal:start_date'
        ];
    }

    public function update()
    {   
        $this->validate();
        activity()->log("extend the election from {$this->end_date} to {$this->end_date}");

        $this->election->end = $this->end_date;
        $this->election->save();

        session()->flash('success', 'Election extended');
        $this->redirect(ListElections::class);
    }
    
    public function render()
    {
        return view('livewire.election-resource.extend-election');
    }
}
