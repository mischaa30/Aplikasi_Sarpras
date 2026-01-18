<?php

namespace App\Http\Controllers;

use App\Models\Sarpras;
use Illuminate\Http\Request;
use App\Models\Lokasi;
use App\Models\KondisiSarpras;
use App\Models\KategoriSarpras;

class SarprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sarpras = Sarpras::with(['lokasi','kondisi','kategori'])
        ->paginate(10);

        return view('admin.sarpras.index',compact('sarpras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sarpras.create',[
            'lokasi' => Lokasi::all(),
            'kondisi' => KondisiSarpras::all(),
            'kategori' => KategoriSarpras::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $r->validate([
            'kode_sarpras' => 'required|unique:sarpras',
            'nama_sarpras' => 'required',
            'id_lokasi' => 'required',
            'id_kondisi_sarpras' => 'required',
            'kategori_id' => 'required',
            'jumlah_stok' => 'required|numeric|min:0'
        ]);

        Sarpras::create($r->all());
        return redirect()->route('admin.sarpras.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sarpras $sarpras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view ('admin.sarpras.edit',[
            'sarpras' => Sarpras::findOrFail($id),
            'lokasi' => Lokasi::all(),
            'kondisi' => KondisiSarpras::all(),
            'kategori' => KategoriSarpras::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r,$id)
    {
        $r->validate([
            'kode_sarpras' =>'required',
            'nama_sarpras' =>'required',
            'id_lokasi' => 'required',
            'id_lokasi_sarpras' => 'required',
            'kategori_id' => 'required',
            'jumlah_stok' => 'required|numeric|min:0'
        ]);

        Sarpras::findOrFail(($id)->update($r->all()));

        return redirect()->route('admin.sarpras.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Sarpras::destroy($id);
        return redirect()->route('admin.sarpras.index');
    }
}
