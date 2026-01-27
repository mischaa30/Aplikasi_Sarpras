<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengaduan;

class ActivityLogController extends Controller
{
    // LOG PEMINJAMAN
    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['user', 'item.sarpras'])
            ->whereNotIn('status', ['Menunggu', 'Dipinjam']); // kecuali masih dalam proses peminjaman

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [ 
                $request->from,
                $request->to
            ]);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return view('admin.activity-log.peminjaman', compact('data'));
    }

    // LOG PENGADUAN
    public function pengaduan(Request $request)
    {
        $query = Pengaduan::with(['user', 'status'])
        ->whereHas('status', fn ($q) => $q->where('nama_status_pengaduan', 'Ditutup'));

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from,
                $request->to
            ]);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return view('admin.activity-log.pengaduan', compact('data'));
    }
}