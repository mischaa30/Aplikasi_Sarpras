<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\SarprasItem;
use App\Models\RiwayatKondisiAlat;
use App\Models\KondisiSarpras;

class PengembalianController extends Controller
{

    /* =========================
       VIEW BERDASARKAN ROLE
    ========================= */
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


    /* =========================
       HALAMAN SCANNER
    ========================= */
    public function scanner()
    {
        return view('pengembalian.scanner');
    }


    /* =========================
       FORM PENGEMBALIAN
    ========================= */
    public function create($id)
    {
        $peminjaman = Peminjaman::with(['detail.sarpras'])
                        ->findOrFail($id);

        $listKondisi = KondisiSarpras::all();

        // Prefill kondisi dari hasil inspeksi SESUDAH (ambil yang terburuk)
        $inspeksiSesudah = \App\Models\Inspeksi::with('hasil.kondisi')
            ->where('peminjaman_id', $peminjaman->id)
            ->where('tipe', 'Sesudah')
            ->first();

        $prefillKondisiId = null;
        if ($inspeksiSesudah) {
            $order = [
                'Baik' => 1,
                'Rusak Ringan' => 2,
                'Rusak Berat' => 3,
                'Hilang' => 4
            ];
            $worst = $inspeksiSesudah->hasil->sortByDesc(function ($h) use ($order) {
                return $order[$h->kondisi->nama_kondisi] ?? 0;
            })->first();
            $prefillKondisiId = $worst?->kondisi_sarpras_id;
        }

        return $this->roleView(
            'pengembalian.create',
            compact('peminjaman','listKondisi','prefillKondisiId')
        );
    }


    /* =========================
       SIMPAN DATA
    ========================= */
    public function store(Request $request)
    {
        $request->validate([

            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tgl_kembali_actual' => 'required|date',

            'detail_id' => 'required|array',
            'kondisi_sarpras_id' => 'required|array',

        ]);

        // Wajib ada inspeksi sesudah pinjam
        $inspeksiSesudah = \App\Models\Inspeksi::with('hasil')
            ->where('peminjaman_id', $request->peminjaman_id)
            ->where('tipe', 'Sesudah')
            ->first();

        if (!$inspeksiSesudah || $inspeksiSesudah->hasil->count() === 0) {
            return back()
                ->withInput()
                ->with('error', 'Inspeksi sesudah pinjam wajib dilakukan sebelum menyimpan pengembalian');
        }

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);


        // Validasi tanggal
        if ($request->tgl_kembali_actual < $peminjaman->tgl_pinjam) {

            return back()
                ->withInput()
                ->withErrors([
                    'tgl_kembali_actual' =>
                    'Tanggal kembali tidak boleh sebelum tanggal pinjam'
                ]);
        }


        DB::transaction(function () use ($request, $peminjaman) {

            // Update peminjaman
            $peminjaman->update([
                'status' => 'Dikembalikan',
                'tgl_kembali_actual' => $request->tgl_kembali_actual
            ]);


            foreach ($request->detail_id as $i => $detailId) {

                $detail = PeminjamanDetail::find($detailId);

                if (!$detail) continue;


                $kondisiId = $request->kondisi_sarpras_id[$i];
                $deskripsi = $request->deskripsi[$i] ?? null;


                // Upload foto
                $foto = null;

                if ($request->hasFile("foto.$i")) {

                    $foto = $request->file("foto.$i")
                            ->store('pengembalian','public');
                }


                // Update item
                $item = SarprasItem::find($detail->sarpras_item_id);

                if ($item) {

                    $item->update([
                        'kondisi_sarpras_id' => $kondisiId
                    ]);
                }


                // Simpan riwayat
                RiwayatKondisiAlat::create([

                    'peminjaman_id' => $peminjaman->id,

                    'peminjaman_detail_id' => $detail->id,

                    'sarpras_id' => $detail->sarpras_id,

                    'sarpras_item_id' => $detail->sarpras_item_id,

                    'kondisi_sarpras_id' => $kondisiId,

                    'deskripsi' => $deskripsi,

                    'foto' => $foto
                ]);


                // Flag hilang
                $kondisi = KondisiSarpras::find($kondisiId);

                if ($kondisi && $kondisi->nama_kondisi === 'Hilang') {

                    $peminjaman->update([
                        'flag_hilang' => 1
                    ]);
                } else {
                    // Increment stock back if not lost
                    if ($detail->sarpras) {
                        $detail->sarpras->increment('stok');
                    }
                }
            }

        });


        return $this->roleRedirect()
            ->with('success','Pengembalian berhasil disimpan');
    }


    /* =========================
       PROSES SCAN QR
    ========================= */
    public function scan(Request $request)
    {

        // Jika QR = ID
        if ($request->raw) {

            $peminjaman = Peminjaman::find($request->raw);

            if (!$peminjaman) {

                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            return response()->json([
                'success' => true,
                'peminjaman_id' => $peminjaman->id
            ]);
        }


        // Jika QR = JSON
        $data = $request->all();

        // 1. Cek ID langsung dari JSON
        if (isset($data['id'])) {
            $peminjaman = Peminjaman::find($data['id']);

            if ($peminjaman) {
                 return response()->json([
                    'success' => true,
                    'peminjaman_id' => $peminjaman->id
                ]);
            }
        }

        // 2. Fallback: Cari by Username & Item (Hanya yang status Disetujui)
        $query = Peminjaman::whereHas('user', function($q) use ($data){
            $q->where('username', $data['peminjam'] ?? '');
        })->where('status', 'Disetujui');

        // Jika di QR ada info item, filter juga
        if (isset($data['item']) && $data['item'] !== '-') {
            $query->whereHas('item', function($q) use ($data) {
                $q->where('nama_item', $data['item']);
            });
        }

        $peminjaman = $query->latest()->first();


        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman aktif tidak ditemukan untuk data QR ini'
            ]);
        }


        return response()->json([
            'success' => true,
            'peminjaman_id' => $peminjaman->id
        ]);
    }

}
