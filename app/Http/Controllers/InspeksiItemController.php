<?php

namespace App\Http\Controllers;

use App\Models\InspeksiItem;
use App\Models\KategoriSarpras;
use Illuminate\Http\Request;

class InspeksiItemController extends Controller
{
    public function index(Request $request)
    {
        $kategoriId = $request->kategori_id;
        $kategori = KategoriSarpras::whereNull('parent_id')->get();

        $query = InspeksiItem::with('kategori');
        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }
        $items = $query->orderBy('kategori_id')->orderBy('nama_item')->paginate(25);

        return view('admin.inspeksi_items.index', compact('items', 'kategori', 'kategoriId'));
    }

    public function create(Request $r)
    {
        return view('admin.inspeksi_items.create', [
            'kategori' => KategoriSarpras::whereNotNull('parent_id')->with('parent')->get(),
            'selectedKategoriId' => $r->kategori_id
        ]);
    }

    public function store(Request $r)
    {
        $r->validate([
            'kategori_id' => 'required|exists:kategori_sarpras,id',
            'nama_item' => 'required|string|max:255',
            'aktif' => 'nullable|boolean'
        ]);

        InspeksiItem::create([
            'kategori_id' => $r->kategori_id,
            'nama_item' => $r->nama_item,
            'aktif' => $r->boolean('aktif')
        ]);

        return redirect()->route('admin.inspeksi_items.index')->with('success', 'Checklist inspeksi ditambahkan');
    }

    public function edit(InspeksiItem $inspeksiItem)
    {
        return view('admin.inspeksi_items.edit', [
            'item' => $inspeksiItem,
            'kategori' => KategoriSarpras::whereNotNull('parent_id')->with('parent')->get()
        ]);
    }

    public function update(Request $r, InspeksiItem $inspeksiItem)
    {
        $r->validate([
            'kategori_id' => 'required|exists:kategori_sarpras,id',
            'nama_item' => 'required|string|max:255',
            'aktif' => 'nullable|boolean'
        ]);

        $inspeksiItem->update([
            'kategori_id' => $r->kategori_id,
            'nama_item' => $r->nama_item,
            'aktif' => $r->boolean('aktif')
        ]);

        return redirect()->route('admin.inspeksi_items.index')->with('success', 'Checklist inspeksi diupdate');
    }

    public function destroy(InspeksiItem $inspeksiItem)
    {
        $inspeksiItem->delete();
        return back()->with('success', 'Checklist inspeksi dihapus');
    }
}
