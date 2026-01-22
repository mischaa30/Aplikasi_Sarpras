<?php

namespace App\Http\Controllers;

use App\Models\Sarpras;
use App\Models\Lokasi;
use App\Models\KategoriSarpras;
use App\Models\KondisiSarpras;
use App\Models\Peminjaman;
use App\Models\SarprasItem;
use Illuminate\Support\Facades\Session;
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

    public function tersedia()
    {
        $sarpras = SarprasItem::where('jumlah', '>', 0)
            ->whereHas('kondisi', function ($q) {
                $q->where('nama_kondisi', 'Baik');
            })
            ->with('sarpras')
            ->get();

        return view('pengguna.sarpras.index', compact('sarpras'));
    }
    // simpan peminjaman
    public function pinjam(Request $r, $id)
    {
        $r->validate([
            'jumlah' => 'required|integer|min:1',
            'tujuan' => 'nullable'
        ]);

        Peminjaman::create([
            'user_id'   => Session::get('user')->id,
            'sarpras_id'=> $id,
            'jumlah'    => $r->jumlah,
            'tgl_pinjam'=> now(),
            'tujuan'    => $r->tujuan,
            'status'    => 'Menunggu'
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil');
    }

    public function create()
    {
        return view('admin.sarpras.create', [
            'parentKategori' => KategoriSarpras::whereNull('parent_id')->get(),
            'childKategori' => KategoriSarpras::whereNotNull('parent_id')->with('parent')
                ->get(),
            'lokasi' => Lokasi::all()
        ]);
    }

    public function store(Request $request)
    {
        $kategori = KategoriSarpras::with('parent')
            ->findOrFail($request->kategori_id);

        // VALIDASI KODE
        if (!$kategori->kode_kategori) {
            return back()->with('error', 'Kode sub kategori belum diisi');
        }

        if ($kategori->parent && !$kategori->parent->kode_kategori) {
            return back()->with('error', 'Kode kategori utama belum diisi');
        }

        // PREFIX (FIX)
        $prefix = $kategori->parent
            ? $kategori->parent->kode_kategori . $kategori->kode_kategori
            : $kategori->kode_kategori;

        $last = Sarpras::where('kode_sarpras', 'like', $prefix . '%')
            ->orderBy('kode_sarpras', 'desc')
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