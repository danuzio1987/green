<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function invitation(User $user)
    {
        if ( !request()->hasValidSignature() || $user->password != 'secret' ) {
           abort(401);
        }

        auth()->login($user);

        return redirect()->route("home");
    }
}
