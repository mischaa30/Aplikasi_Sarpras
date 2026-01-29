@extends('layouts.admin')

@section('title','Asset Health')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">📊 Laporan Asset Health</h3>

{{-- ALAT RUSAK --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary bg-opacity-10 text-primary fw-semibold">
        Alat Rusak / Butuh Maintenance
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
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
                    <td>
                        <span class="badge bg-primary-subtle text-primary">
                            {{ $item->kondisi->nama_kondisi }}
                        </span>
                    </td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- TOP 10 --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary bg-opacity-10 text-primary fw-semibold">
        Top 10 Alat Paling Sering Rusak
    </div>
    <div class="card-body">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
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

{{-- ALAT HILANG --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary bg-opacity-10 text-primary fw-semibold">
        Alat Hilang
    </div>
    <div class="card-body">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
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

@endsection
