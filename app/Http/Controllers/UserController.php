<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function show (User $user)
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }

    public function edit (User $user)
    {
        return view ('users.edit', [
            'user' => $user,
        ]);
    }

    public function update (User $user, Request $request)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('users.show', [
            'user' => $user,
        ]);
    }

}
