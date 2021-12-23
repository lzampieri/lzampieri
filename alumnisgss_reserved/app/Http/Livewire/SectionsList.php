<?php

namespace App\Http\Livewire;

use App\Models\Section;
use Livewire\Component;

class SectionsList extends Component
{


    public function render()
    {
        return view('livewire.sections-list', [
            'sections' => Section::all()
        ]);
    }
}
