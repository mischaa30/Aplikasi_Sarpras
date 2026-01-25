<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminApproveController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'sarpras', 'item'])->get();
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
}
