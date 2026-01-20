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
            'items.kondisi'
        ])->paginate(10);

        return view('admin.sarpras.index', compact('sarpras'));
    }

    public function create()
    {
        return view('admin.sarpras.create', [
            'kategori' => KategoriSarpras::all(),
            'lokasi' => Lokasi::all()
        ]);
    }

    public function store(Request $r)
    {
        $r->validate([
            'kode_sarpras' => 'required|unique:sarpras',
            'nama_sarpras' => 'required',
            'kategori_id' => 'required',
            'id_lokasi' => 'required'
        ]);

        Sarpras::create($r->all());
        return redirect()->route('admin.sarpras.index');
    }

    public function show(Sarpras $sarpras)
    {
        $sarpras->load('items.kondisi');

        return view('admin.sarpras.show', [
            'sarpras' => $sarpras,
            'listKondisi' => KondisiSarpras::all()
        ]);
    }

    public function edit(Sarpras $sarpras)
    {
        return view('admin.sarpras.edit', [
            'sarpras' => $sarpras,
            'kategori' => KategoriSarpras::all(),
            'lokasi' => Lokasi::all()
        ]);
    }

    public function update(Request $r, Sarpras $sarpras)
    {
        $sarpras->update($r->all());
        return redirect()->route('admin.sarpras.index');
    }

    public function destroy(Sarpras $sarpras)
    {
        $sarpras->delete();
        return redirect()->route('admin.sarpras.index');
    }
}