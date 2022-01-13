<?php

namespace App\Http\Middleware;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $auth = NULL;
        $sections = [];
        if( Auth::check() ) {
            $user = Auth::user();
            $auth = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'user_verified_at' => $user->user_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'permissions' => $user->getPermissionNames()
            ];
            if( Auth::user()->email_verified_at !== null && Auth::user()->user_verified_at !== null ) {
                $sections = Section::select('shortname', 'title')->get();
            }
        }
        return array_merge(parent::share($request), [
            'auth' => $auth,
            'sections' => $sections
        ]);
    }
}
