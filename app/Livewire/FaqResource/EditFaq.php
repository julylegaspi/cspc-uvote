<?php

namespace App\Livewire\FaqResource;

use App\Models\Faq;
use Livewire\Component;
use Livewire\Attributes\Rule;

class EditFaq extends Component
{
    public Faq $faq;

    #[Rule('required|string')]
    public $question;

    #[Rule('required|string')]
    public $answer;

    public function mount(Faq $faq)
    {
        $this->faq = $faq;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
    }

    public function update()
    {
        $this->validate();

        $this->faq->question = $this->question;
        $this->faq->answer = $this->answer;
        $this->faq->save();

        session()->flash('success', 'FAQ updated.');

        $this->redirect(ListFaqs::class);
    }
    
    public function render()
    {
        return view('livewire.faq-resource.edit-faq');
    }
}
