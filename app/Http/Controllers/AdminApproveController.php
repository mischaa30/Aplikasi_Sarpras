<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminApproveController extends Controller
{
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

    /* ===============================
       LIST
    =============================== */
    public function index()
    {
        $peminjaman = Peminjaman::with([
                'user',
                'sarpras',
                'item',
                'approver' // ← TAMBAH
            ])
            ->whereNull('tgl_kembali_actual')
            ->whereIn('status',['Menunggu','Disetujui'])
            ->latest()
            ->get();

        return $this->roleView('peminjaman.index', compact('peminjaman'));
    }

    /* ===============================
       SETUJUI
    =============================== */
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'Disetujui',
            'disetujui_oleh' => auth()->id(), // ← SIMPAN ACC
        ]);

        return back()->with('success','Peminjaman disetujui');
    }

    /* ===============================
       TOLAK
    =============================== */
    public function tolak(Request $r, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'Ditolak',
            'alasan' => $r->alasan,
            'disetujui_oleh' => auth()->id(), // ← CATAT JUGA PENOLAK
        ]);

        return back()->with('success','Peminjaman ditolak');
    }

    /* ===============================
       BUKTI
    =============================== */
    public function bukti($id)
    {
        $peminjaman = Peminjaman::with([
            'user',
            'item.sarpras',
            'approver' // ← TAMBAH
        ])->findOrFail($id);

        $qrData = [
            'peminjam' => $peminjaman->user->username ?? '-',
            'item' => $peminjaman->item?->nama_item ?? '-',
            'tgl_pinjam' => $peminjaman->tgl_pinjam,
            'status' => $peminjaman->status,
            'acc' => $peminjaman->approver->username ?? '-',
        ];

        return $this->roleView('peminjaman.bukti', compact('peminjaman','qrData'));
    }
}
