<?php

namespace App\Http\Controllers;

//ambil atau memanggil data model
use App\Models\User;
use App\Models\Role;
use App\Models\Activity_Log;

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
        //ambil semua data user dan role
        $user = User::with('role')->paginate(10); //Menggunakan paginate
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
        //Menghindari data ganda & tidak valid
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
        $r->validate([
            'username' => 'required',
            'id_role'  => 'required'
        ]);

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
        User::findOrFail($id)->delete();
        return redirect()->route('admin.user.index'); //kembali ke halaman data user
        //
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        // CATAT ACTIVITY LOG
        Activity_Log::create([
            'user_id'   => auth()->id(), // admin yg restore
            'aksi'      => 'restore_user',
            'deskripsi' => 'Restore user: ' . $user->name,
        ]);

        return redirect()->back()->with('success', 'User berhasil direstore');
    }
}
