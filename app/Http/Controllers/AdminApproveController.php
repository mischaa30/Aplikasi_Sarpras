<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\Qrcode;

class AdminApproveController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'sarpras', 'item'])
            ->whereNull('tgl_kembali_actual') //belum dikembalikan
            ->whereIn('status',['Menunggu','Disetujui'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Disetujui';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman disetujui');
    }

    public function tolak(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Ditolak';
        $peminjaman->alasan = $request->alasan;
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman ditolak');
    }

    public function bukti($id)
    {
        $peminjaman = Peminjaman::with(['user', 'item.sarpras'])
            ->findOrFail($id);

            $qrData = [
                'peminjam' => $peminjaman->user->username ?? '-',
                'item' => $peminjaman->item?->nama_item?? '-',
                'tgl_pinjam' => $peminjaman->tgl_pinjam,
                'tgl_kembali' => $peminjaman->tgl_kembali_actual,
                'status' => $peminjaman->status,
            ];

        return view('admin.peminjaman.bukti', compact('peminjaman','qrData'));
    }
}
