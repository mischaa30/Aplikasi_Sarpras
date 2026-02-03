<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKondisiAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanAssetHealthController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start ?? now()->subMonths(6);
        $end   = $request->end ?? now();

        /* ============================
           ALAT RUSAK / MAINTENANCE
        ============================ */
        $alatRusak = RiwayatKondisiAlat::with(['item','kondisi'])
            ->whereNotNull('sarpras_item_id') 
            ->whereHas('kondisi', function ($q) {
                $q->whereIn('nama_kondisi', [
                    'Rusak Berat',
                    'Butuh Maintenance'
                ]);
            })
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();


        /* ============================
           ALAT HILANG
        ============================ */
        $alatHilang = RiwayatKondisiAlat::with(['item','peminjaman.user'])
            ->whereNotNull('sarpras_item_id') 
            ->whereHas('kondisi', function ($q) {
                $q->where('nama_kondisi', 'Hilang');
            })
            ->latest()
            ->get();


        /* ============================
           TOP 10 PALING SERING RUSAK (BERDASARKAN ITEM)
        ============================ */
        $alatSeringRusak = RiwayatKondisiAlat::select(
                'sarpras_item_id',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('sarpras_item_id')
            ->whereHas('kondisi', function ($q) {
                $q->whereIn('nama_kondisi', [
                    'Rusak Ringan',
                    'Rusak Berat',
                    'Butuh Maintenance'
                ]);
            })
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('sarpras_item_id')
            ->orderByDesc('total')
            ->with('item')
            ->limit(10)
            ->get();


        /* ============================
           TIMELINE MAINTENANCE
        ============================ */
        $maintenanceHistory = RiwayatKondisiAlat::with(['item','kondisi'])
            ->whereNotNull('sarpras_item_id')
            ->latest()
            ->get();


        /* ============================
           CHART TREND KERUSAKAN
        ============================ */
        $trendKerusakan = RiwayatKondisiAlat::select(
                DB::raw("DATE_FORMAT(created_at,'%Y-%m') as bulan"),
                DB::raw('COUNT(*) as total')
            )
            ->whereHas('kondisi', function ($q) {
                $q->whereIn('nama_kondisi', [
                    'Rusak Ringan',
                    'Rusak Berat',
                    'Butuh Maintenance'
                ]);
            })
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();


        return view('admin.laporan.asset-health', compact(
            'alatRusak',
            'alatSeringRusak',
            'alatHilang',
            'maintenanceHistory',
            'trendKerusakan'
        ));
    }
}
