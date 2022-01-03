<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Inertia\Inertia;

class SectionController extends Controller
{
    /**
     * Display the section content.
     *
     * @return \Inertia\Response
     */
    public function show( Section $section )
    {
        return Inertia::render('Section', [
            'section' => $section,
        ]);
    }
}
