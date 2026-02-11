<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Inspeksi;
use App\Models\InspeksiItemResult;
use App\Models\KondisiSarpras;
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
    public function index(Request $request)
    {
        $q = $request->q ?? null;

        $query = Peminjaman::with([
            'user',
            'sarpras',
            'item',
            'approver'
        ])
            ->whereNull('tgl_kembali_actual')
            ->whereIn('status', ['Menunggu', 'Disetujui']);

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->whereHas('user', function ($qu) use ($q) {
                    $qu->where('username', 'like', "%{$q}%");
                })->orWhereHas('item', function ($qi) use ($q) {
                    $qi->where('nama_item', 'like', "%{$q}%");
                })->orWhere('status', 'like', "%{$q}%");
            });
        }

        $peminjaman = $query->latest()->paginate(25);

        return $this->roleView('peminjaman.index', compact('peminjaman'));
    }

    /* ===============================
       SETUJUI
    =============================== */
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $inspeksi = Inspeksi::with('hasil.kondisi')
            ->where('peminjaman_id', $peminjaman->id)
            ->where('tipe', 'Sebelum')
            ->first();

        if (!$inspeksi || $inspeksi->hasil->count() === 0) {
            return back()->with('error', 'Inspeksi sebelum pinjam wajib dilakukan terlebih dahulu');
        }

        $adaRusakBerat = $inspeksi->hasil->contains(function ($h) {
            return $h->kondisi?->nama_kondisi === 'Rusak Berat' || $h->kondisi?->nama_kondisi === 'Hilang';
        });

        if ($adaRusakBerat) {
            return back()->with('error', 'Peminjaman tidak dapat disetujui: hasil inspeksi menunjukkan Rusak Berat/Hilang');
        }

        $peminjaman->update([
            'status' => 'Disetujui',
            'disetujui_oleh' => auth()->id(), // ← SIMPAN ACC
        ]);

        // Decrement stock for each item
        foreach ($peminjaman->detail as $detail) {
            if ($detail->sarpras) {
                $detail->sarpras->decrement('stok');
            }
        }

        return back()->with('success', 'Peminjaman disetujui');
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

        return back()->with('success', 'Peminjaman ditolak');
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
            'id' => $peminjaman->id,
            'peminjam' => $peminjaman->user->username ?? '-',
            'item' => $peminjaman->item?->nama_item ?? '-',
            'tgl_pinjam' => $peminjaman->tgl_pinjam,
            'status' => $peminjaman->status,
            'acc' => $peminjaman->approver->username ?? '-',
        ];

        return $this->roleView('peminjaman.bukti', compact('peminjaman', 'qrData'));
    }
}
