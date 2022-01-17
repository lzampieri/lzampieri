<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FileController extends Controller
{
    /**
     * Display the section content.
     *
     * @return \Inertia\Response
     */
    public function upload( $section_id, Request $request )
    {
        $request->validate([
            'thefile' => 'required|file'
        ]);
        $section = Section::withTrashed()->with('attachments')->findOrFail( $section_id );


        $path = $request->file('thefile')->storePublicly('public/uploads');

        $att = new Attachment();
        $att->fileurl = Storage::url( $path );
        $att->filename = $request->file('thefile')->getClientOriginalName();
        $att->section()->associate( $section );
        $att->save();
            
        return Redirect::route('section', [ "section" => $section ] );
    }

    public function save( $section_id, Request $request )
    {
        

        $section = Section::withTrashed()->findOrFail( $section_id );

        $section->title = $request->title;
        $section->content = $request->content;

        $section->save();

        return Redirect::route('section', [ "section" => $section ] );
    }

}
