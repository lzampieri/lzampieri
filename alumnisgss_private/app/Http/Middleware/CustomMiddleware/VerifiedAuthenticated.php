<?php

namespace App\Http\Middleware\CustomMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifiedAuthenticated {

    public function handle( Request $request, Closure $next ) {
        if( !Auth::check() ) {
            return redirect()->route('login');
        }
        if( Auth::user()->email_verified_at === null || Auth::user()->user_verified_at === null ) {
            return redirect()->route('unverified');
        }
        return $next($request);
    }
    
}