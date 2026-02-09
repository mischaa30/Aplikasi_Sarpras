<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarpras;
use App\Models\Sarpras;
use App\Models\Activity_Log;
use Illuminate\Http\Request;

class KategoriSarprasController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q ?? null;

        $query = KategoriSarpras::whereNull('deleted_at')->with('children')
            ->whereNull('parent_id');

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('nama_kategori', 'like', "%{$q}%")
                    ->orWhereHas('children', function ($qc) use ($q) {
                        $qc->where('nama_kategori', 'like', "%{$q}%");
                    });
            });
        }

        $kategori = $query->paginate(25);

        // Jika ada query pencarian, filter child supaya hanya menampilkan sub-kategori yang cocok
        if ($q) {
            foreach ($kategori as $parent) {
                $filteredChildren = $parent->children->filter(function ($c) use ($q) {
                    return stripos($c->nama_kategori ?? '', $q) !== false;
                })->values();

                $parent->setRelation('children', $filteredChildren);
            }
        }

        return view('admin.kategori.index', compact('kategori'));
    }

    public function restore($id)
    {
        $kategori = KategoriSarpras::onlyTrashed()->findOrFail($id);
        $kategori->restore();

        Activity_Log::create([
            'user_id' => auth()->id(),
            'aksi' => 'restore_kategori',
            'deskripsi' => 'Restore kategori: ' . $kategori->nama_kategori,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil direstore');
    }

    public function trash(Request $request)
    {
        $q = $request->q ?? null;

        $query = KategoriSarpras::onlyTrashed()->whereNull('parent_id');

        if ($q) {
            $query->where('nama_kategori', 'like', "%{$q}%");
        }

        $kategori = $query->paginate(25);

        return view('admin.kategori.trash', compact('kategori'));
    }

    public function forceDelete($id)
    {
        $k = KategoriSarpras::onlyTrashed()->findOrFail($id);
        $name = $k->nama_kategori;
        $k->forceDelete();

        Activity_Log::create([
            'user_id' => auth()->id(),
            'aksi' => 'force_delete_kategori',
            'deskripsi' => 'Permanently deleted kategori: ' . $name,
        ]);

        return redirect()->back()->with('success', 'Kategori dihapus permanen');
    }

    public function create()
    {
        // ambil semua kategori untuk jadi pilihan parent
        $kategori = KategoriSarpras::whereNull('parent_id')->get();

        return view('admin.kategori.create', compact('kategori'));
    }

    public function store(Request $r)
    {
        $kode = 'KAT' . str_pad(KategoriSarpras::count() + 1, 3, '0', STR_PAD_LEFT);

        KategoriSarpras::create([
            'nama_kategori' => $r->nama_kategori,
            'parent_id' => $r->parent_id,
            'kode_kategori' => $kode
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
    $kategori = KategoriSarpras::findOrFail($id);

    // ❌ Cek apakah punya sub kategori
    $punyaChild = KategoriSarpras::where('parent_id', $id)->exists();

    if ($punyaChild) {
        return redirect()->back()->with(
            'error',
            'Kategori tidak bisa dihapus karena masih memiliki sub-kategori.'
        );
    }

    // ❌ Cek apakah dipakai sarpras
    $dipakai = Sarpras::where('kategori_id', $id)->exists();

    if ($dipakai) {
        return redirect()->back()->with(
            'error',
            'Kategori tidak bisa dihapus karena masih digunakan oleh data sarpras.'
        );
    }

    $kategori->delete();

    return redirect()->route('admin.kategori.index')
        ->with('success', 'Kategori berhasil dihapus');
}

    public function userIndex(Request $request)
    {
        $q = $request->q ?? null;

        $query = KategoriSarpras::whereNull('parent_id');

        if ($q) {
            $query->where('nama_kategori', 'like', "%{$q}%");
        }

        $kategori = $query->paginate(25);
        return view('pengguna.kategori.index', compact('kategori'));
    }

    public function userShow(Request $request, KategoriSarpras $kategori)
    {
        $q = $request->q ?? null;

        $subKategori = KategoriSarpras::where('parent_id', $kategori->id)->get();

        // default kosong biar GA ERROR
        $sarpras = collect();

        // kalau TIDAK ADA sub kategori → ambil sarpras
        if ($subKategori->count() == 0) {
            $query = Sarpras::where('kategori_id', $kategori->id);

            if ($q) {
                $query->where('nama_sarpras', 'like', "%{$q}%");
            }

            $sarpras = $query->paginate(25);
        }

        return view(
            'pengguna.kategori.show',
            compact('kategori', 'subKategori', 'sarpras')
        );
    }
}
