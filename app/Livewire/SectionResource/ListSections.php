<?php

namespace App\Livewire\SectionResource;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;

class ListSections extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function destroy(Section $section)
    {
        $section->delete();

        session()->flash('success', 'Section deleted.');

        $this->redirect(ListSections::class);
    }
    
    public function render()
    {
        $sections = Section::where('level', 'like', '%'.$this->query.'%')
                ->orWhere('name', 'like', '%'.$this->query.'%')
                ->with('course')
                ->paginate(10);
        return view('livewire.section-resource.list-sections', [
            'sections' => $sections,
        ]);
    }
}
