<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\KategoriSarpras;
use App\Models\Status_Pengaduan;
use App\Models\PengaduanCatatan;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    private function roleView($view, $data = [])
    {
        if (request()->is('admin/*')) {
            return view('admin.' . $view, $data);
        }

        if (request()->is('petugas/*')) {
            return view('petugas.' . $view, $data);
        }

        if (request()->is('pengguna/*')) {
            return view('pengguna.' . $view, $data);
        }

        abort(403);
    }

    /*
    ================= USER =================
    */

    public function myPengaduan(Request $request)
    {
        $q = $request->q ?? null;

        $query = Pengaduan::with('status', 'kategori', 'lokasi', 'diprosesOleh')
            ->where('user_id', Auth::id());

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('judul', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%")
                    ->orWhereHas('kategori', function ($kc) use ($q) {
                        $kc->where('nama_kategori', 'like', "%{$q}%");
                    })->orWhereHas('lokasi', function ($kl) use ($q) {
                        $kl->where('nama_lokasi', 'like', "%{$q}%");
                    });
            });
        }

        $data = $query->latest()->paginate(25);

        return view('pengguna.pengaduan.my', compact('data'));
    }

    public function create()
    {
        return view('pengguna.pengaduan.create', [
            'kategori' => KategoriSarpras::all(),
            'lokasi' => Lokasi::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kategori_sarpras_id' => 'required|exists:kategori_sarpras,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'foto' => 'nullable|image|max:2048'
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')
                ->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'user_id' => Auth::id(),
            'status_pengaduan_id' => 1,
            'kategori_sarpras_id' => $request->kategori_sarpras_id,
            'lokasi_id' => $request->lokasi_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'diproses_oleh' => null
        ]);

        return redirect()
            ->route('pengguna.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dibuat');
    }

    /*
    ================= ADMIN + PETUGAS =================
    */

    public function index(Request $request)
    {
        $q = $request->q ?? null;

        $query = Pengaduan::with('user', 'status', 'kategori', 'diprosesOleh')
            ->whereHas('status', function ($q2) {
                $q2->whereNotIn('nama_status_pengaduan', ['Selesai', 'Ditutup']);
            });

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($qu) use ($q) {
                        $qu->where('username', 'like', "%{$q}%");
                    })->orWhereHas('kategori', function ($kc) use ($q) {
                        $kc->where('nama_kategori', 'like', "%{$q}%");
                    })->orWhereHas('lokasi', function ($kl) use ($q) {
                        $kl->where('nama_lokasi', 'like', "%{$q}%");
                    });
            });
        }

        $data = $query->latest()->paginate(25);

        return $this->roleView('pengaduan.index', compact('data'));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(
            'user',
            'status',
            'kategori',
            'lokasi',
            'catatan.user',
            'diprosesOleh'
        )->findOrFail($id);

        $status = Status_Pengaduan::all();

        return $this->roleView(
            'pengaduan.show',
            compact('pengaduan', 'status')
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pengaduan_id' =>
            'required|exists:status_pengaduans,id'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->status_pengaduan_id =
            $request->status_pengaduan_id;

        // ✅ simpan siapa yg memproses
        $pengaduan->diproses_oleh = Auth::id();

        $pengaduan->save();

        return back()->with('success', 'Status diubah');
    }

    public function addCatatan(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required'
        ]);

        PengaduanCatatan::create([
            'pengaduan_id' => $id,
            'user_id' => Auth::id(),
            'catatan' => $request->catatan
        ]);

        return back()->with('success', 'Catatan ditambahkan');
    }
}
