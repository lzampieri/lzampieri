<?php

namespace App\Http\Livewire;

use App\Models\Section;
use Livewire\Component;

class SectionShow extends Component
{
    public $section;

    public function mount(Section $section)
    {
        $this->section = $section;
    }

    public function render()
    {
        return view('livewire.section-show')
            ->extends('layout');
    }
}
