<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\SarprasItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = Peminjaman::with('item.sarpras')
            ->where('user_id', Auth::id())
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

        // hanya boleh pinjam jika kondisi Baik
        if ($item->kondisi->nama_kondisi !== 'Baik') {
            abort(403);
        }

        $r->validate([
            'tujuan' => 'required'
        ]);

        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'sarpras_id' => $item->sarpras_id,
            'sarpras_item_id' => $item->id,
            'tgl_pinjam' => now(),
            'tujuan' => $r->tujuan,
            'status' => 'Menunggu'
        ]);

        PeminjamanDetail::create([
            'peminjaman_id' => $peminjaman->id,
            'sarpras_id' => $item->sarpras_id,
            'sarpras_item_id' => $item->id
        ]);

        return redirect()->route('pengguna.peminjaman.index');
    }

}
