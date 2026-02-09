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

    private function roleRedirect()
    {
        if (request()->is('admin/*')) {
            return redirect()->route('admin.peminjaman.index');
        }

        if (request()->is('petugas/*')) {
            return redirect()->route('petugas.peminjaman.index');
        }

        abort(403);
    }

    public function create($id)
    {
        $peminjaman = Peminjaman::with(['detail.sarpras'])->findOrFail($id);
        $listKondisi = KondisiSarpras::all();

        return $this->roleView(
            'pengembalian.create',
            compact('peminjaman', 'listKondisi')
        ); return view('pengembalian.scanner');
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tgl_kembali_actual' => 'required|date',
            'detail_id' => 'required|array',
            'kondisi_sarpras_id' => 'required|array',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        //Cegah tanggal kembali sebelum tanggal pinjam
        if ($request->tgl_kembali_actual < $peminjaman->tgl_pinjam) {
            return back()
                ->withInput()
                ->withErrors([
                    'tgl_kembali_actual' => 'Tanggal pengembalian tidak boleh sebelum tanggal peminjaman'
                ]);
        }


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

                $foto = null;
                if ($request->hasFile("foto.$index")) {
                    $foto = $request->file("foto.$index")
                        ->store('pengembalian', 'public');
                }

                $item = SarprasItem::find($detail->sarpras_item_id);
                if ($item) {
                    $item->update([
                        'kondisi_sarpras_id' => $kondisiId
                    ]);
                }

                RiwayatKondisiAlat::create([
                    'peminjaman_id' => $peminjaman->id,
                    'peminjaman_detail_id' => $detail->id,
                    'sarpras_id' => $detail->sarpras_id,
                    'sarpras_item_id' => $detail->sarpras_item_id,
                    'kondisi_sarpras_id' => $kondisiId,
                    'deskripsi' => $deskripsi,
                    'foto' => $foto
                ]);

                $kondisi = KondisiSarpras::find($kondisiId);
                if ($kondisi && $kondisi->nama_kondisi === 'Hilang') {
                    $peminjaman->update(['flag_hilang' => 1]);
                }
            }
        });

        return $this->roleRedirect()
            ->with('success', 'Pengembalian berhasil dicatat');
    }
    public function scan(Request $request)
{
    // kalau QR hanya ID
    if ($request->raw) {

        $peminjaman = Peminjaman::find($request->raw);

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'peminjaman_id' => $peminjaman->id
        ]);
    }

    // kalau QR JSON
    $data = $request->all();

    $peminjaman = Peminjaman::whereHas('user',
        fn($q)=>$q->where('username',$data['peminjam'] ?? '')
    )->first();

    if (!$peminjaman) {
        return response()->json([
            'success'=>false,
            'message'=>'Data tidak cocok'
        ]);
    }

    return response()->json([
        'success'=>true,
        'peminjaman_id'=>$peminjaman->id
    ]);
}

}
