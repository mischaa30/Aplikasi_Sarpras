<?php

namespace App\Http\Controllers;

//ambil atau memanggil data model
use App\Models\User;
use App\Models\Role;

//ambil data dari form
use Illuminate\Http\Request;

//hash pw
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('role')->get(); //ambil semua data user dan role
        return view('admin.user.index', compact('user')); //kirim data ke view user.index
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all(); //ambil data role
        return view('admin.user.create', compact('role')); //kirim data
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        User::create([
            'username' => $r->username,
            'password' => Hash::make($r->password),
            'id_role'  => $r->id_role
        ]);

        return redirect()->route('admin.user.index');
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
        return view('admin.user.edit', compact('user', 'role')); //Mengirim data ke view edit
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, User $user)
    {
        $data = [
            'username' => $r->username,
            'id_role' => $r->id_role
        ];

        if ($r->password) {
            $data['password'] = Hash::make($r->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //menghapus data user sesuai id
        User::destroy($id);
        return redirect()->route('admin.user.index'); //kembali ke halaman data user
        //
    }
}
