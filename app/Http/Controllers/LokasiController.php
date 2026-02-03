<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /* =========================
       LIST DATA
    ========================== */
    public function index(Request $request)
    {
        $q = $request->q ?? null;

        $query = Lokasi::latest();

        if ($q) {
            $query->where('nama_lokasi', 'like', "%{$q}%");
        }

        $lokasi = $query->paginate(25);

        return view('admin.lokasi.index', compact('lokasi'));
    }


    /* =========================
       FORM CREATE
    ========================== */
    public function create()
    {
        return view('admin.lokasi.create');
    }


    /* =========================
       STORE
    ========================== */
    public function store(Request $r)
    {
        $r->validate([
            'nama_lokasi' => 'required|unique:lokasis,nama_lokasi'
        ]);

        Lokasi::create([
            'nama_lokasi' => $r->nama_lokasi
        ]);

        return redirect()
            ->route('admin.lokasi.index')
            ->with('success', 'Lokasi berhasil ditambahkan');
    }


    /* =========================
       FORM EDIT
    ========================== */
    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        return view('admin.lokasi.edit', compact('lokasi'));
    }


    /* =========================
       UPDATE
    ========================== */
    public function update(Request $r, $id)
    {
        $r->validate([
            'nama_lokasi' =>
            'required|unique:lokasis,nama_lokasi,' . $id
        ]);

        $lokasi = Lokasi::findOrFail($id);

        $lokasi->update([
            'nama_lokasi' => $r->nama_lokasi
        ]);

        return redirect()
            ->route('admin.lokasi.index')
            ->with('success', 'Lokasi berhasil diupdate');
    }


    /* =========================
       DELETE (SOFT DELETE)
    ========================== */
    public function destroy($id)
    {
        Lokasi::findOrFail($id)->delete();

        return redirect()
            ->route('admin.lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus');
    }
}
