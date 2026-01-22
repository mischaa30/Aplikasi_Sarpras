<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarpras;
use Illuminate\Http\Request;

class KategoriSarprasController extends Controller
{
    public function index()
    {
        $kategori = KategoriSarpras::with('children')
            ->whereNull('parent_id')
            ->get();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        // ambil semua kategori untuk jadi pilihan parent
        $kategori = KategoriSarpras::whereNull('parent_id')->get();

        return view('admin.kategori.create', compact('kategori'));
    }

    public function store(Request $r)
    {
        KategoriSarpras::create([
            'nama_kategori' => $r->nama_kategori,
            'parent_id' => $r->parent_id
        ]);

        return redirect()->route('admin.kategori.index');
    }

    public function edit($id)
    {
        $kategori = KategoriSarpras::findOrFail($id);
        $parent = KategoriSarpras::whereNull('parent_id')->get();

        return view('admin.kategori.edit', compact('kategori', 'parent'));
    }

    public function update(Request $r, $id)
    {
        KategoriSarpras::where('id', $id)->update([
            'nama_kategori' => $r->nama_kategori,
            'parent_id' => $r->parent_id
        ]);

        return redirect()->route('admin.kategori.index');
    }

    public function destroy($id)
    {
        KategoriSarpras::findOrFail($id)->delete();
        return redirect()->route('admin.kategori.index');
    }
}
