<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminApproveController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Tentukan folder view berdasarkan prefix URL
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

        abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | List peminjaman
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $peminjaman = Peminjaman::with(['user','sarpras','item'])
            ->whereNull('tgl_kembali_actual')
            ->whereIn('status',['Menunggu','Disetujui'])
            ->latest()
            ->get();

        return $this->roleView('peminjaman.index', compact('peminjaman'));
    }

    /*
    |--------------------------------------------------------------------------
    | Setujui
    |--------------------------------------------------------------------------
    */
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Disetujui';
        $peminjaman->save();

        return back()->with('success','Peminjaman disetujui');
    }

    /*
    |--------------------------------------------------------------------------
    | Tolak
    |--------------------------------------------------------------------------
    */
    public function tolak(Request $r, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Ditolak';
        $peminjaman->alasan = $r->alasan;
        $peminjaman->save();

        return back()->with('success','Peminjaman ditolak');
    }

    /*
    |--------------------------------------------------------------------------
    | Bukti
    |--------------------------------------------------------------------------
    */
    public function bukti($id)
    {
        $peminjaman = Peminjaman::with(['user','item.sarpras'])
            ->findOrFail($id);

        $qrData = [
            'peminjam' => $peminjaman->user->username ?? '-',
            'item' => $peminjaman->item?->nama_item ?? '-',
            'tgl_pinjam' => $peminjaman->tgl_pinjam,
            'status' => $peminjaman->status,
        ];

        return $this->roleView('peminjaman.bukti', compact('peminjaman','qrData'));
    }
}
