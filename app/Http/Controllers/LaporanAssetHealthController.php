<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKondisiAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanAssetHealthController extends Controller
{
    public function index(Request $request){
        $start = $request->start ?? now()->subMonths(6);
        $end = $request->end ?? now();

        //Daftar alat rusak atau butuh maintenance
        $alatRusak = RiwayatKondisiAlat::with(['sarpras','kondisi'])
        ->whereHas('kondisi',function($q) {
            $q->whereIn('nama_kondisi',['Rusak Berat','Butuh Maintenance']);
        })
        ->whereBetween('created_at',[$start,$end])
        ->get();

        //Alat Hilang

        $alatHilang = RiwayatKondisiAlat::with(['sarpras', 'peminjaman.user'])
            ->whereHas('kondisi', function ($q) {
                $q->where('nama_kondisi', 'Hilang');
            })
            ->get();

        //Top 10 alat paling sering rusak
        $alatSeringRusak = RiwayatKondisiAlat::select(
            'sarpras_id',
            DB::raw('COUNT(*) as total')
        )
        ->whereHas('kondisi',function ($q){
            $q->whereIn('nama_kondisi',['Rusak Ringan','Rusak Berat','Butuh Maintenance']);
        })
        ->whereBetween('created_at',[$start,$end])
        ->groupBy('sarpras_id')
        ->orderByDesc('total')
        ->with('sarpras')
        ->limit(10)
        ->get();

        //Maintenance history (timeline)
        $maintenanceHistory = RiwayatKondisiAlat::with(['sarpras', 'kondisi'])
            ->orderBy('created_at', 'desc')
            ->get();

        //Chart: trend kerusakan per bulan
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
