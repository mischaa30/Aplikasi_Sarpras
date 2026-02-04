<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\SarprasItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q ?? null;

        $query = Peminjaman::with('item.sarpras')
            ->where('user_id', Auth::id());

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->whereHas('item.sarpras', function ($qs) use ($q) {
                    $qs->where('nama_sarpras', 'like', "%{$q}%");
                })->orWhereHas('item', function ($qi) use ($q) {
                    $qi->where('nama_item', 'like', "%{$q}%");
                })->orWhere('status', 'like', "%{$q}%");
            });
        }

        $data = $query->latest()->paginate(25);

        return view('pengguna.peminjaman.index', compact('data'));
    }


    public function create(SarprasItem $item)
    {
        $kondisi = $item->kondisi->nama_kondisi ?? '';

        if (!in_array($kondisi, ['Baik', 'Rusak Ringan'])) {
            abort(403, 'Item tidak bisa dipinjam karena kondisi tidak layak');
        }

        return view('pengguna.peminjaman.create', compact('item'));
    }

    public function store(Request $r, SarprasItem $item)
    {
        $kondisi = $item->kondisi->nama_kondisi ?? '';

        if (!in_array($kondisi, ['Baik', 'Rusak Ringan'])) {
            abort(403, 'Item tidak bisa dipinjam karena kondisi tidak layak');
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

    public function exportPdf(Request $request)
    {
        $query = Peminjaman::with(['user', 'item', 'approver']);

        // Kalau mau filter tanggal (opsional)
        if ($request->filled('tanggal')) {
            $query->whereDate('tgl_pinjam', $request->tanggal);
        }

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('admin.activity-log.pdf', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('activity-log.pdf');
    }
}
