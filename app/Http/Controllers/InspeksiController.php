<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Inspeksi;
use App\Models\InspeksiItem;
use App\Models\InspeksiItemResult;
use App\Models\KondisiSarpras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspeksiController extends Controller
{
    private function roleView($view, $data = [])
    {
        if (request()->is('admin/*')) {
            return view('admin.'.$view, $data);
        }
        if (request()->is('petugas/*')) {
            return view('petugas.'.$view, $data);
        }
        abort(403);
    }
    private function roleRedirect($peminjamanId, $tipe)
    {
        $isAdmin = request()->is('admin/*');
        $isPetugas = request()->is('petugas/*');
        if ($tipe === 'Sebelum') {
            if ($isAdmin) return redirect()->route('admin.peminjaman.index');
            if ($isPetugas) return redirect()->route('petugas.peminjaman.index');
        } else {
            if ($isAdmin) return redirect()->route('admin.pengembalian.create', $peminjamanId);
            if ($isPetugas) return redirect()->route('petugas.pengembalian.create', $peminjamanId);
        }
        abort(403);
    }

    public function form($peminjamanId, $tipe)
    {
        $tipe = ucfirst(strtolower($tipe)) === 'Sesudah' ? 'Sesudah' : 'Sebelum';
        $peminjaman = Peminjaman::with(['item.sarpras.kategori', 'detail.sarpras.kategori'])->findOrFail($peminjamanId);

        $kategoriId = $peminjaman->item?->sarpras?->kategori_id ?? $peminjaman->detail->first()?->sarpras?->kategori_id;

        $checklist = InspeksiItem::where('kategori_id', $kategoriId)->where('aktif', true)->orderBy('nama_item')->get();
        $listKondisi = KondisiSarpras::all();

        $existing = Inspeksi::with('hasil.item')
            ->where('peminjaman_id', $peminjaman->id)
            ->where('tipe', $tipe)
            ->first();

        return $this->roleView('inspeksi.form', compact('peminjaman', 'tipe', 'checklist', 'listKondisi', 'existing'));
    }

    public function store(Request $r, $peminjamanId, $tipe)
    {
        $tipe = ucfirst(strtolower($tipe)) === 'Sesudah' ? 'Sesudah' : 'Sebelum';

        $r->validate([
            'item_id' => 'required|array',
            'kondisi_id' => 'required|array',
            'catatan' => 'array'
        ]);

        $peminjaman = Peminjaman::findOrFail($peminjamanId);

        DB::transaction(function () use ($r, $peminjaman, $tipe) {
            $inspeksi = Inspeksi::updateOrCreate(
                [
                    'peminjaman_id' => $peminjaman->id,
                    'tipe' => $tipe
                ],
                [
                    'checked_by' => auth()->id(),
                    'checked_at' => now()
                ]
            );

            InspeksiItemResult::where('inspeksi_id', $inspeksi->id)->delete();

            foreach ($r->item_id as $i => $itemId) {
                InspeksiItemResult::create([
                    'inspeksi_id' => $inspeksi->id,
                    'inspeksi_item_id' => $itemId,
                    'kondisi_sarpras_id' => $r->kondisi_id[$i],
                    'catatan' => $r->catatan[$i] ?? null
                ]);
            }
        });

        return $this->roleRedirect($peminjaman->id, $tipe)
            ->with('success', 'Inspeksi '.$tipe.' disimpan');
    }
}
