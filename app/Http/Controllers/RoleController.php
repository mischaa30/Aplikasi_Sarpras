<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // tampilkan semua role
    public function index()
    {
        $roles = Role::withTrashed()->get();
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
        Role::withTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }
}
