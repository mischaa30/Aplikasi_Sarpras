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

    public function userIndex($kategoriId)
    {
        $sarpras = Sarpras::withCount('items')
            ->where('kategori_id', $kategoriId)
            ->get();

        return view('pengguna.sarpras.index', compact('sarpras'));
    }

    // menampilkan sarpras yang punya item dengan kondisi "Tersedia"
    public function tersedia(Request $request)
    {
        $sarpras = Sarpras::with(['kategori', 'items.kondisi'])
            ->whereHas('items', function ($q) {
                $q->whereHas('kondisi', function ($k) {
                    $k->where('nama_kondisi', 'Tersedia');
                });
            })
            ->get();

        return view('pengguna.sarpras.index', compact('sarpras'));
    }

    public function create()
    {
        return view('admin.sarpras.create', [
            'parentKategori' => KategoriSarpras::whereNull('parent_id')->get(),
            'childKategori' => KategoriSarpras::whereNotNull('parent_id')->with('parent')->get(),
            'lokasi' => Lokasi::all()
        ]);
    }
    public function store(Request $request)
    {
        $kategori = KategoriSarpras::with('parent')
            ->findOrFail($request->kategori_id);

        if (!$kategori->kode_kategori) {
            return back()->with('error', 'Kode sub kategori belum diisi');
        }

        if ($kategori->parent && !$kategori->parent->kode_kategori) {
            return back()->with('error', 'Kode kategori utama belum diisi');
        }

        $prefix = $kategori->parent
            ? $kategori->parent->kode_kategori . $kategori->kode_kategori
            : $kategori->kode_kategori;

        // include data yang sudah dihapus
        $last = Sarpras::withTrashed()
            ->where('kode_sarpras', 'like', $prefix . '%')
            ->orderByRaw("CAST(SUBSTRING(kode_sarpras, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
            ->first();

        $urutan = $last
            ? intval(substr($last->kode_sarpras, strlen($prefix))) + 1
            : 1;

        $kodeSarpras = $prefix . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        Sarpras::create([
            'kode_sarpras' => $kodeSarpras,
            'nama_sarpras' => $request->nama_sarpras,
            'kategori_id' => $request->kategori_id,
            'id_lokasi' => $request->id_lokasi
        ]);

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

    public function showUser($id)
    {
        $sarpras = Sarpras::with([
            'items.kondisi',
            'items.peminjamanAktif'
        ])->findOrFail($id);

        return view('pengguna.sarpras.show', compact('sarpras'));
    }

    public function edit(Sarpras $sarpras)
    {
        return view('admin.sarpras.edit', [
            'sarpras' => $sarpras,
            'kategori' => KategoriSarpras::whereNotNull('parent_id')->with('parent')->get(),
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
