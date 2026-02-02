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
    /*
    |--------------------------------------------------------------------------
    | Helper pilih view berdasarkan prefix route
    |--------------------------------------------------------------------------
    */
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
    |--------------------------------------------------------------------------
    | ================= USER =================
    |--------------------------------------------------------------------------
    */

    public function myPengaduan()
    {
        $data = Pengaduan::with('status','kategori','lokasi')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

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
            'foto' => $foto
        ]);

        return redirect()
            ->route('pengguna.pengaduan.index')
            ->with('success','Pengaduan berhasil dibuat');
    }

    /*
    |--------------------------------------------------------------------------
    | ============= ADMIN + PETUGAS =============
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $data = Pengaduan::with('user','status','kategori')
            ->whereHas('status', function ($q) {
                $q->whereNotIn(
                    'nama_status_pengaduan',
                    ['Selesai','Ditutup']
                );
            })
            ->latest()
            ->get();

        return $this->roleView('pengaduan.index', compact('data'));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(
            'user',
            'status',
            'kategori',
            'catatan.user'
        )->findOrFail($id);

        $status = Status_Pengaduan::all();

        return $this->roleView(
            'pengaduan.show',
            compact('pengaduan','status')
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pengaduan_id' =>
                'required|exists:status_pengaduans,id'
        ]);

        Pengaduan::findOrFail($id)->update([
            'status_pengaduan_id' =>
                $request->status_pengaduan_id
        ]);

        return back()->with('success','Status diubah');
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

        return back()->with('success','Catatan ditambahkan');
    }
}
