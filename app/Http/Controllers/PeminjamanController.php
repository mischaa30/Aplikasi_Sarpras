<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\SarprasItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = Session::get('user');

        $data = Peminjaman::with('item.sarpras')
            ->where('user_id', $user->id)
            ->get();

        return view('pengguna.peminjaman.index', compact('data'));
    }

    public function create(SarprasItem $item)
    {
        // hanya boleh pinjam jika kondisi Baik
        if ($item->kondisi->nama_kondisi !== 'Baik') {
            abort(403);
        }

        return view('pengguna.peminjaman.create', compact('item'));
    }

    public function store(Request $r, SarprasItem $item)
    {
        $user = Session::get('user');

        // hanya boleh pinjam jika kondisi Baik
        if ($item->kondisi->nama_kondisi !== 'Baik') {
            abort(403);
        }

        $r->validate([
            'tgl_kembali' => 'required|date|after_or_equal:today',
            'tujuan' => 'required'
        ]);

        Peminjaman::create([
            'user_id' => $user->id,
            'sarpras_id' => $item->sarpras_id,
            'sarpras_item_id' => $item->id,
            'tgl_pinjam' => now(),
            'tgl_kembali' => $r->tgl_kembali,
            'tujuan' => $r->tujuan,
            'status' => 'Menunggu'
        ]);

        return redirect()->route('pengguna.peminjaman.index');
    }
}
