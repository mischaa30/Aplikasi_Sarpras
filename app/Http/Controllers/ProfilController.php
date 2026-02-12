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
        $user = User::findOrFail(Auth::id());

        $r->validate([
            'username' => 'required',

            // hanya wajib jika password_baru diisi
            'password_lama' => 'required_with:password_baru',
            'password_baru' => 'nullable|min:4|confirmed',
        ]);

        // update username
        $user->username = $r->username;

        // jika user isi password baru → proses ganti password
        if ($r->filled('password_baru')) {

            // cek password lama
            if (!Hash::check($r->password_lama, $user->password)) {
                return back()->withErrors([
                    'password_lama' => 'Password lama salah'
                ])->withInput();
            }

            // tidak boleh sama dengan password lama
            if (Hash::check($r->password_baru, $user->password)) {
                return back()->withErrors([
                    'password_baru' => 'Password baru tidak boleh sama dengan password lama'
                ])->withInput();
            }

            // simpan password baru
            $user->password = Hash::make($r->password_baru);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diupdate')->withInput();
    }
}
