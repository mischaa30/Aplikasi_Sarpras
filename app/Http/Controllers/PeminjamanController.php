<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function pinjam(Request $r)
    {
        Peminjaman::create([
            'kode_pinjam' => 'PMJ-' . time(),
            'user_id' => session('user')->user_id,
            'sarpras_id' => $r->sarpras_id,
            'jumlah' => $r->jumlah,
            'tgl_pinjam' => $r->tgl_pinjam,
            'tgl_kembali' => $r->tgl_kembali,
            'tujuan' => $r->tujuan,
            'status' => 'Menunggu'
        ]);
        return back()->with('success', 'Pengajuan dikirim');
}

}
