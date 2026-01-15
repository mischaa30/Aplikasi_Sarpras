<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('role')->get();
        return view('user.index', compact('user'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();
        return view('user.create', compact('role'));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        User::create([
            'username' => $r->username,
            'password' => $r->password,
            'id_role'  => $r->id_role
        ]);

        return redirect('/user');
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = Role::all();
        return view('user.edit', compact('user', 'role'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, User $user)
    {
        $user->update([
            'username' => $r->username,
            'id_role' => $r->id_role
        ]);

        return redirect('/user');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/user');
        //
    }
}
