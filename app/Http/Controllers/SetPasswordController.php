<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetPasswordController extends Controller
{
    public function create()
    {
        return view('auth.setpassword');
    }

    public function store(StorePasswordRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route("home")->with("status", "Senha definida com sucesso!");
    }
}
