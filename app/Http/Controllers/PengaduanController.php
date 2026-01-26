<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\KategoriSarpras;
use App\Models\Status_Pengaduan;
use App\Models\PengaduanCatatan;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengaduanController extends Controller
{
    // USER: Lihat riwayat pengaduan
    public function myPengaduan()
    {
        if (!Session::has('user')) {
            return redirect('/login');
        }

        $user = Session::get('user');

        $data = Pengaduan::with('status', 'kategori', 'lokasi')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('pengguna.pengaduan.my', compact('data'));
    }

    // USER: Form buat pengaduan
    public function create()
    {
        $kategori = KategoriSarpras::all();
        $lokasi = Lokasi::all();
        return view('pengguna.pengaduan.create', compact('kategori', 'lokasi'));
    }

    // USER: Simpan pengaduan
    public function store(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('/login');
        }

        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'kategori_sarpras_id' => 'required|exists:kategori_sarpras,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan', 'public');
        }

        $user = Session::get('user');
        Pengaduan::create([
            'user_id' => $user->id,
            'status_pengaduan_id' => 1,
            'kategori_sarpras_id' => $request->kategori_sarpras_id,
            'lokasi_id' => $request->lokasi_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);
        return redirect()->route('pengguna.pengaduan.index')->with('success', 'Pengaduan berhasil dibuat');
    }

    // ADMIN/PETUGAS: Lihat semua pengaduan
    public function index()
    {
        $data = Pengaduan::with('user', 'status', 'kategori')
            ->latest()
            ->get();

        return view('admin.pengaduan.index', compact('data'));
    }

    // ADMIN/PETUGAS: Detail pengaduan
    public function show($id)
    {
        $pengaduan = Pengaduan::with('user', 'status', 'kategori', 'catatan.user')
            ->findOrFail($id);

        $status = Status_Pengaduan::all();
        return view('admin.pengaduan.show', compact('pengaduan', 'status'));
    }

    // ADMIN/PETUGAS: Update status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pengaduan_id' => 'required|exists:status_pengaduans,id',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([
            'status_pengaduan_id' => $request->status_pengaduan_id,
        ]);

        return back()->with('success', 'Status berhasil diubah');
    }

    // ADMIN/PETUGAS: Tambah catatan
    public function addCatatan(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $user = Session::get('user');

        PengaduanCatatan::create([
            'pengaduan_id' => $id,
            'user_id' => $user->id,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Catatan berhasil ditambahkan');
    }
}
