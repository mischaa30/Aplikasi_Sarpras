<?php

namespace App\Http\Controllers;

use App\Models\Sarpras;
use App\Models\Lokasi;
use App\Models\KategoriSarpras;
use App\Models\KondisiSarpras;
use App\Models\Activity_Log;
use Illuminate\Http\Request;

class SarprasController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q ?? null;

        $query = Sarpras::whereNull('deleted_at')->with([
            'lokasi',
            'kategori',
            'items.kondisi'
        ]);

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('kode_sarpras', 'like', "%{$q}%")
                    ->orWhere('nama_sarpras', 'like', "%{$q}%")
                    ->orWhereHas('lokasi', function ($ql) use ($q) {
                        $ql->where('nama_lokasi', 'like', "%{$q}%");
                    })
                    ->orWhereHas('kategori', function ($kc) use ($q) {
                        $kc->where('nama_kategori', 'like', "%{$q}%");
                    });
            });
        }

        $sarpras = $query->paginate(25);

        return view('admin.sarpras.index', compact('sarpras'));
    }

    public function restore($id)
    {
        $sarpras = Sarpras::onlyTrashed()->findOrFail($id);
        $sarpras->restore();

        Activity_Log::create([
            'user_id' => auth()->id(),
            'aksi' => 'restore_sarpras',
            'deskripsi' => 'Restore sarpras: ' . $sarpras->nama_sarpras,
        ]);

        return redirect()->back()->with('success', 'Sarpras berhasil direstore');
    }

    public function trash(Request $request)
    {
        $q = $request->q ?? null;

        $query = Sarpras::onlyTrashed()->with(['lokasi', 'kategori']);

        if ($q) {
            $query->where('nama_sarpras', 'like', "%{$q}%");
        }

        $sarpras = $query->paginate(25);

        return view('admin.sarpras.trash', compact('sarpras'));
    }

    public function forceDelete($id)
    {
        $s = Sarpras::onlyTrashed()->findOrFail($id);
        $name = $s->nama_sarpras;
        $s->forceDelete();

        Activity_Log::create([
            'user_id' => auth()->id(),
            'aksi' => 'force_delete_sarpras',
            'deskripsi' => 'Permanently deleted sarpras: ' . $name,
        ]);

        return redirect()->back()->with('success', 'Sarpras dihapus permanen');
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

    public function showUser(Request $request, $id)
{
    $q = $request->q ?? null;

    $sarpras = Sarpras::with([
        'lokasi',
        'items' => function ($query) use ($q) {

            // hanya kondisi layak
            $query->whereHas('kondisi', function ($k) {
                $k->whereIn('nama_kondisi', ['Baik','Rusak Ringan']);
            });

            // tidak sedang dipinjam
            $query->whereDoesntHave('peminjamanAktif');

            // search tetap jalan
            if ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('nama_item', 'like', "%$q%")
                       ->orWhereHas('kondisi', function ($k) use ($q) {
                           $k->where('nama_kondisi', 'like', "%$q%");
                       });
                });
            }

            $query->with(['kondisi','peminjamanAktif']);
        }
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
    public function indexPetugas(Request $request)
    {
        $q = $request->q ?? null;

        $query = Sarpras::with(['lokasi', 'kategori.parent','items.kondisi']);

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('kode_sarpras', 'like', "%{$q}%")
                    ->orWhere('nama_sarpras', 'like', "%{$q}%")
                    ->orWhereHas('lokasi', function ($ql) use ($q) {
                        $ql->where('nama_lokasi', 'like', "%{$q}%");
                    })
                    ->orWhereHas('kategori', function ($kc) use ($q) {
                        $kc->where('nama_kategori', 'like', "%{$q}%");
                    });
            });
        }

        $sarpras = $query->paginate(25);

        return view('petugas.sarpras.index', compact('sarpras'));
    }

    public function detailPetugas(Sarpras $sarpras)
    {
        $sarpras->load([
            'lokasi',
            'items.kondisi'
        ]);

        return view('petugas.sarpras.detail', compact('sarpras'));
    }

}
