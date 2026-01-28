<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\SarprasItem;
use App\Models\RiwayatKondisiAlat;
use App\Models\KondisiSarpras;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function create($id)
    {
        $peminjaman = Peminjaman::with(['detail.item'])->findOrFail($id);
        $listKondisi = KondisiSarpras::all();

        return view('admin.pengembalian.create', compact('peminjaman', 'listKondisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tgl_kembali_actual' => 'required|date',
            'detail_id' => 'required|array',
            'kondisi_sarpras_id' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

            $peminjaman->update([
                'status' => 'Dikembalikan',
                'tgl_kembali_actual' => $request->tgl_kembali_actual
            ]);

            foreach ($request->detail_id as $index => $detailId) {

                $detail = PeminjamanDetail::find($detailId);
                if (!$detail) continue;

                $kondisiId = $request->kondisi_sarpras_id[$index];
                $deskripsi = $request->deskripsi[$index] ?? null;

                // upload foto
                $foto = null;
                if ($request->hasFile("foto.$index")) {
                    $foto = $request->file("foto.$index")
                        ->store('pengembalian', 'public');
                }

                // update kondisi item
                $item = SarprasItem::find($detail->sarpras_item_id);
                if ($item) {
                    $item->update([
                        'kondisi_sarpras_id' => $kondisiId
                    ]);
                }

                // simpan riwayat
                RiwayatKondisiAlat::create([
                    'peminjaman_id' => $peminjaman->id,
                    'peminjaman_detail_id' => $detail->id,
                    'sarpras_item_id' => $detail->sarpras_item_id,
                    'kondisi_sarpras_id' => $kondisiId,
                    'deskripsi' => $deskripsi,
                    'foto' => $foto
                ]);

                // flag hilang
                $kondisi = KondisiSarpras::find($kondisiId);
                if ($kondisi && $kondisi->nama_kondisi === 'Hilang') {
                    $peminjaman->update(['flag_hilang' => 1]);
                }
            }
        });

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Pengembalian berhasil dicatat');
    }
}
