<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SectionController extends Controller
{
    /**
     * Display the section content.
     *
     * @return \Inertia\Response
     */
    public function show( $section_id )
    {
        $section = Section::withTrashed()->findOrFail( $section_id );
        if( $section->reserved )
            Auth::user()->can('access reserved sections') || abort(403);
        if( $section->trashed() )
            Auth::user()->can('edit sections') || abort(403);
            
        return Inertia::render('Section', [
            'section' => $section,
        ]);
    }
}
