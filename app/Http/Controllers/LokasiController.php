<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::all();
        return view('admin.lokasi.index', compact('lokasi'));
    }

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'nama_lokasi' => 'required|unique:lokasi,nama_lokasi'
        ]);

        Lokasi::create([
            'nama_lokasi' => $r->nama_lokasi
        ]);

        return redirect()->route('admin.lokasi.index');
    }

    public function destroy($id)
    {
        Lokasi::findOrFail($id)->delete();
        return redirect()->route('admin.lokasi.index');
    }
}
