<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Activity_Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->q ?? null;

        $query = User::whereNull('deleted_at')->with('role');

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('username', 'like', "%{$q}%")
                   ->orWhereHas('role', function ($qr) use ($q) {
                       $qr->where('nama_role', 'like', "%{$q}%");
                   });
            });
        }

        $user = $query->paginate(25);
        return view('admin.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();
        return view('admin.user.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $r->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:4',
            'id_role'  => 'required'
        ]);

        User::create([
            'username' => $r->username,
            'password' => Hash::make($r->password),
            'id_role'  => $r->id_role
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = Role::all();
        return view('admin.user.edit', compact('user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, User $user)
    {
        $r->validate([
            'username' => 'required',
            'id_role'  => 'required',
            'password' => 'nullable|min:4'
        ]);

        $data = [
            'username' => $r->username,
            'id_role'  => $r->id_role
        ];

        if (!empty($r->password)) {
            $data['password'] = Hash::make($r->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy($id)
    {
        if ($id == auth()->id()) {
            return redirect()->back()->with('eror', 'Tidak bisa menghapus akun sendiri!');
        }

        User::findOrFail($id)->delete();
        return redirect()->route('admin.user.index')
                         ->with('success', 'User berhasil dihapus');
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        Activity_Log::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'restore_user',
            'deskripsi' => 'Restore user: ' . $user->username,
        ]);

        return redirect()->back()->with('success', 'User berhasil direstore');
    }

    /**
     * Display trashed users.
     */
    public function trash(Request $request)
    {
        $q = $request->q ?? null;

        $query = User::onlyTrashed()->with('role');

        if ($q) {
            $query->where('username', 'like', "%{$q}%");
        }

        $user = $query->paginate(25);
        return view('admin.user.trash', compact('user'));
    }

    /**
     * Permanently delete a trashed user.
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ($user->id == auth()->id()) {
            return redirect()->back()->with('eror', 'Tidak bisa menghapus akun sendiri!');
        }

        $name = $user->username;
        $user->forceDelete();

        Activity_Log::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'force_delete_user',
            'deskripsi' => 'Permanently deleted user: ' . $name,
        ]);

        return redirect()->back()->with('success', 'User dihapus permanen');
    }
}
