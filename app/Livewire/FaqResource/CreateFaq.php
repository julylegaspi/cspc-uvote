<?php

namespace App\Livewire\FaqResource;

use App\Models\Faq;
use Livewire\Component;
use Livewire\Attributes\Rule;

class CreateFaq extends Component
{
    #[Rule('required|string')]
    public $question;

    #[Rule('required|string')]
    public $answer;

    public function save()
    {
        $this->validate();

        Faq::create([
            'question' => $this->question,
            'answer' => $this->answer
        ]);

        session()->flash('success', 'FAQ created.');

        $this->redirect(ListFaqs::class);
    }

    public function render()
    {
        return view('livewire.faq-resource.create-faq');
    }
}
