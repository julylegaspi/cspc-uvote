<?php

namespace App\Livewire\FaqResource;

use App\Models\Faq;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class ListFaqs extends Component
{
    public Faq $faq;

    #[Rule('required|string')]
    public $question = "";

    #[Rule('required|string')]
    public $answer = "";

    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function store()
    {
        $this->validate();

        Faq::create([
            'question' => $this->question,
            'answer' => $this->answer
        ]);

        session()->flash('success', 'FAQ created.');

        $this->redirect(ListFaqs::class);
    }

    public function edit(Faq $faq)
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

    public function destroy(Faq $faq)
    {
        $faq->delete();

        session()->flash('success', 'FAQ deleted.');

        $this->redirect(ListFaqs::class);
    }

    public function cancel()
    {
        $this->question = "";
        $this->answer = "";
        $this->resetValidation();
    }
    
    public function render()
    {
        $faqs = Faq::where('question', 'like', '%'.$this->query.'%')
                ->orWhere('answer', 'like', '%'.$this->query.'%')
                ->paginate(10);
        return view('livewire.faq-resource.list-faqs', [
            'faqs' => $faqs
        ]);
    }
}
