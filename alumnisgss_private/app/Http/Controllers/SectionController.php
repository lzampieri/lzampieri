<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        $section['trashed'] = $section->trashed();
        if( $section->reserved )
            Auth::user()->can('access reserved sections') || abort(403);
        if( $section->trashed() )
            Auth::user()->can('edit sections') || abort(403);
            
        return Inertia::render('Section', [
            'section' => $section,
        ]);
    }

    public function edit( $section_id )
    {
        $section = Section::withTrashed()->findOrFail( $section_id );
        $section['trashed'] = $section->trashed();
            
        return Inertia::render('EditSection', [
            'section' => $section,
        ]);
    }

    public function save( $section_id, Request $request )
    {
        $request->validate([
            'shortname' => 'required|string|max:25|alpha_dash',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $section = Section::withTrashed()->findOrFail( $section_id );

        $section->shortname = $request->shortname;
        $section->title = $request->title;
        $section->content = $request->content;

        $section->save();

        return Redirect::route('section', [ "section" => $section ] );
    }

    public function reserved( $section_id, Request $request )
    {
        $request->validate([
            'reserved' => 'required|boolean'
        ]);

        $section = Section::withTrashed()->findOrFail( $section_id );

        if( $section->trashed() )
            Auth::user()->can('edit sections') || abort(403);

        $section->reserved = $request->reserved;
        $section->save();

        return Redirect::route('section', [ "section" => $section ] );
    }

    public function trashed( $section_id, Request $request )
    {
        $request->validate([
            'trashed' => 'required|boolean'
        ]);

        $section = Section::withTrashed()->findOrFail( $section_id );

        if( $section->trashed() !== $request->trashed ) {
            if( $request->trashed ) {
                $section->delete();
            } else {
                $section->restore();
            }
        }

        return Redirect::route('section', [ "section" => $section ] );
    }
}
