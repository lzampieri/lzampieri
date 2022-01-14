<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    
    public function list(Request $request)
    {
        $users = User::with('permissions')->get();
        return Inertia::render('User/Edit', [
            'users' => $users->map( function($user) { return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'user_verified_at' => $user->user_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'permissions' => $user->getPermissionNames()
            ]; } ),
            'permissions' => Permission::get(['name'])
        ]);
    }

    public function edit_perms(Request $request)
    {
        $request->validate([
            'should_have' => 'required|boolean',
            'user' => 'required|exists:users,id',
            'perm' => 'required|exists:permissions,name'
        ]);
        
        if( $request->user == Auth::user()->id ) {
            return Redirect::back()->withErrors(['user' => __('validation.notmyself')]);
        }

        $user = User::find( $request->user );
        $perm = $request->perm;

        if( $request->should_have ) {
            $user->givePermissionTo( $perm );
        } else {
            $user->revokePermissionTo( $perm );
        }
        
        return Redirect::route('user.edit');
    }
}
