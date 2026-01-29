<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit()
    {
        return view('profil.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $r)
    {
        $r->validate([
            'username' => 'required',
            'password' => 'nullable|min:4'
        ]);

        $user = User::findOrFail(Auth::id());

        $user->username = $r->username;

        if ($r->password) {
            $user->password = Hash::make($r->password);
        }

        $user->save();
        return back()->with('succes', 'Profil berhasil di update');
    }
}
