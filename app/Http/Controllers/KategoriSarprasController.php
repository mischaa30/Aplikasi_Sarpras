<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarpras;
use Illuminate\Http\Request;

class KategoriSarprasController extends Controller
{
    /**
     * Display a listing of the resource (READ).
     */
    public function index()
    {
        $kategori = KategoriSarpras::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    //Menampilkan form tambah
    public function create()
    {
        return view('admin.kategori.create'); //tampil form tambah
    }

    /**
     * Store a newly created resource in storage.
     */
    //Menyimpan data baru(create)
    public function store(Request $r)
    {
        KategoriSarpras::create([
            'nama_kategori' => $r->nama_kategori //ambil input dari form
        ]);
        return redirect()->route('admin.kategori.index'); //kembali ke index
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriSarpras $kategori_Sarpras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    //Menampilkan form edit
    public function edit($id)
    {
        $kategori = KategoriSarpras::findOrFail($id);
        return view('admin.kategori.edit',compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    //Menyimpan perubahan (update)
    public function update(Request $r,$id)
    {
        KategoriSarpras::where('id',$id)->update([
            'nama_kategori' => $r->nama_kategori  //update data
        ]);

        return redirect()->route('admin.kategori.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    //menghapus data
    public function destroy($id)
    {
        KategoriSarpras::findOrFail($id)->delete();
        return redirect()->route('admin.kategori.index');
    }

    //restore
}
