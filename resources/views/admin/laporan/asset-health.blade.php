@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">📊 Laporan Asset Health</h3>

    {{-- ================= ALAT RUSAK ================= --}}
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            Daftar Alat Rusak / Butuh Maintenance
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Alat</th>
                        <th>Kondisi</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alatRusak as $item)
                    <tr>
                        <td>{{ $item->sarpras->nama_sarpras }}</td>
                        <td>{{ $item->kondisi->nama_kondisi }}</td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= TOP 10 RUSAK ================= --}}
    <div class="card mb-4">
        <div class="card-header bg-warning">
            Top 10 Alat Paling Sering Rusak
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Alat</th>
                        <th>Jumlah Rusak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alatSeringRusak as $row)
                    <tr>
                        <td>{{ $row->sarpras->nama_sarpras }}</td>
                        <td>{{ $row->total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= ALAT HILANG ================= --}}
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            Alat Hilang
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Alat</th>
                        <th>Peminjam Terakhir</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alatHilang as $item)
                    <tr>
                        <td>{{ $item->sarpras->nama_sarpras }}</td>
                        <td>{{ $item->peminjaman->user->username ?? '-' }}</td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= CHART ================= --}}
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            Trend Kerusakan Per Bulan
        </div>
        <div class="card-body">
            <canvas
                id="chartKerusakan"
                data-labels='@json($trendKerusakan->pluck("bulan"))'
                data-totals='@json($trendKerusakan->pluck("total"))'>
            </canvas>

        </div>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const canvas = document.getElementById('chartKerusakan');

        const labels = JSON.parse(canvas.dataset.labels);
        const totals = JSON.parse(canvas.dataset.totals);

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Kerusakan',
                    data: totals,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                }]
            }
        });

    });
</script>
@endsection