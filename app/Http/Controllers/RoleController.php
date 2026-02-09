<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Activity_Log;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // tampilkan semua role
    public function index()
    {
        $roles = Role::whereNull('deleted_at')->get();
        return view('admin.role.index', compact('roles'));
    }

    // form tambah role
    public function create()
    {
        return view('admin.role.create');
    }

    // simpan role
    public function store(Request $r)
    {
        $r->validate([
            'nama_role' => 'required|unique:roles,nama_role'
        ]);

        Role::create([
            'nama_role' => $r->nama_role
        ]);

        return redirect()->route('admin.role.index');
    }

    // soft delete role
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back();
    }

    // restore role
    public function restore($id)
    {
        $role = Role::withTrashed()->findOrFail($id);
        $role->restore();

        Activity_Log::create([
            'user_id' => auth()->id(),
            'aksi' => 'restore_role',
            'deskripsi' => 'Restore role: ' . $role->nama_role,
        ]);

        return redirect()->back()->with('success', 'Role berhasil direstore');
    }

    public function trash(Request $request)
    {
        $roles = Role::onlyTrashed()->get();
        return view('admin.role.trash', compact('roles'));
    }

    public function forceDelete($id)
    {
        $role = Role::onlyTrashed()->findOrFail($id);
        $name = $role->nama_role;
        $role->forceDelete();

        Activity_Log::create([
            'user_id' => auth()->id(),
            'aksi' => 'force_delete_role',
            'deskripsi' => 'Permanently deleted role: ' . $name,
        ]);

        return redirect()->back()->with('success', 'Role dihapus permanen');
    }

    // form edit role
    public function edit(Role $role)
    {
        return view('admin.role.edit', compact('role'));
    }

    // update role
    public function update(Request $r, Role $role)
    {
        $r->validate([
            'nama_role' => 'required|unique:roles,nama_role,' . $role->id
        ]);

        $role->update([
            'nama_role' => $r->nama_role
        ]);

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil diupdate');
    }
}
