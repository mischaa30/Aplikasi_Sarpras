<?php

namespace App\Http\Controllers;

use App\Models\Sarpras;
use App\Models\Lokasi;
use App\Models\KategoriSarpras;
use App\Models\KondisiSarpras;
use Illuminate\Http\Request;

class SarprasController extends Controller
{
    public function index()
    {
        $sarpras = Sarpras::with([
            'lokasi',
            'kategori',
            'kondisiDetail.kondisi'
        ])->paginate(10);

        return view('admin.sarpras.index', compact('sarpras'));
    }

    public function create()
    {
        $lokasi   = Lokasi::all();
        $kategori = KategoriSarpras::all();

        return view('admin.sarpras.create', compact(
            'lokasi',
            'kategori'
        ));
    }

    public function store(Request $r)
    {
        $r->validate([
            'kode_sarpras' => 'required|unique:sarpras',
            'nama_sarpras' => 'required',
            'id_lokasi'    => 'required',
            'kategori_id'  => 'required'
        ]);

        Sarpras::create($r->only([
            'kode_sarpras',
            'nama_sarpras',
            'id_lokasi',
            'kategori_id'
        ]));

        return redirect()->route('admin.sarpras.index');
    }

    public function show(Sarpras $sarpras)
    {
        $sarpras->load([
            'lokasi',
            'kategori',
            'kondisiDetail.kondisi'
        ]);

        $listKondisi = KondisiSarpras::all();

        return view('admin.sarpras.show', compact(
            'sarpras',
            'listKondisi'
        ));
    }

    public function edit(Sarpras $sarpras)
    {
        $lokasi   = Lokasi::all();
        $kategori = KategoriSarpras::all();

        return view('admin.sarpras.edit', compact(
            'sarpras',
            'lokasi',
            'kategori'
        ));
    }

    public function update(Request $r, Sarpras $sarpras)
    {
        $r->validate([
            'kode_sarpras' => 'required',
            'nama_sarpras' => 'required',
            'id_lokasi'    => 'required',
            'kategori_id'  => 'required'
        ]);

        $sarpras->update($r->only([
            'kode_sarpras',
            'nama_sarpras',
            'id_lokasi',
            'kategori_id'
        ]));

        return redirect()->route('admin.sarpras.index');
    }

    public function destroy($id)
    {
        Sarpras::findOrFail($id)->delete();
        return redirect()->route('admin.user.index');
    }

    //restore
}
