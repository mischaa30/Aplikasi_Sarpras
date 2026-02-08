<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengaduan;
use App\Models\Status_Pengaduan;
use App\Models\Activity_Log;

class ActivityLogController extends Controller
{
    // LOG PEMINJAMAN
    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with([
            'user', 
            'item.sarpras',
            'riwayatKondisi.kondisi',
            'riwayatKondisi.item'
        ])
            ->whereNotIn('status', ['Menunggu', 'Dipinjam']);

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return view('admin.activity-log.peminjaman', compact('data'));
    }

    // LOG PENGADUAN
    public function pengaduan(Request $request)
    {
        $query = Pengaduan::with(['user', 'status']);

        //filter tanggal,belum digunakan
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from,
                $request->to
            ]);
        }

        //filter status
        if ($request->filled('status')) {
            $status = $request->status;
            $query->whereHas('status', function ($q) use ($status) {
                $q->where('nama_status_pengaduan', $status); // harus sama dengan kolom DB
            });
        }

        $data = $query->orderBy('created_at', 'desc')->get();
        $listStatus = Status_Pengaduan::all();

        return view('admin.activity-log.pengaduan', compact('data','listStatus'));
    }

    //LOG LOGIN
    public function login(Request $request)
    {
        $query = Activity_Log::with('user')
            ->whereIn('aksi', ['login', 'logout']);

        //FILTER TANGGAL
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return view('admin.activity-log.login', compact('data'));
    }
}