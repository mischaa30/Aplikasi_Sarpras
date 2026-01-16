<?php

namespace App\Http\Controllers;

//ambil atau memanggil data model
use App\Models\User;
use App\Models\Role;

//ambil data dari form
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('role')->get(); //ambil semua data user dan role
        return view('user.index', compact('user')); //kirim data ke view user.index
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all(); //ambil data role
        return view('user.create', compact('role')); //kirim data
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        //menyimpan data user ke database
        User::create([
            'username' => $r->username,
            'password' => $r->password,
            'id_role'  => $r->id_role
        ]);

        return redirect('/user'); //kembali ke halaman data user
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
        $user = User::findOrFail($id); // Mengambil data user berdasarkan id
        $role = Role::all(); //Mengambil semua role
        return view('user.edit', compact('user', 'role')); //Mengirim data ke view edit
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, User $user)
    {
        //Update data user
        $user->update([
            'username' => $r->username,
            'id_role' => $r->id_role
        ]);

        return redirect('/user'); //kembali ke halaman data user
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //menghapus data user sesuai id
        User::destroy($id);
        return redirect('/user'); //kembali ke halaman data user
        //
    }
}
