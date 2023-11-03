<?php

namespace App\Livewire\FaqResource;

use App\Models\Faq;
use Livewire\Component;
use Livewire\WithPagination;

class ListFaqs extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        session()->flash('success', 'FAQ deleted.');

        $this->redirect(ListFaqs::class);
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
