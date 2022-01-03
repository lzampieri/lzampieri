<?php

namespace App\Http\Middleware\CustomMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotAuthenticated {

    public function handle( Request $request, Closure $next ) {
        if( Auth::check() ) {
            return redirect()->route('homepage');
        }
        return $next($request);
    }

}