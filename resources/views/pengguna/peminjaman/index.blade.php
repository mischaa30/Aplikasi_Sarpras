@extends('layouts.pengguna')

@section('content')
<div class="container-fluid mt-3">

    <h3 class="mb-4 text-primary fw-semibold">
        📋 Pinjaman Saya
    </h3>

    <div class="card">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Riwayat Peminjaman</span>

            <form method="GET" class="d-flex" style="gap:.5rem">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari barang, item, status...">
                <button class="btn btn-light btn-sm">Cari</button>
            </form>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Barang</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $p)
                    <tr>
                        <td>@if($data instanceof \Illuminate\Pagination\LengthAwarePaginator){{ $data->firstItem() + $loop->index }}@else{{ $loop->iteration }}@endif</td>
                        <td>
                            {{ $p->item?->sarpras?->nama_sarpras ?? '-' }}
                            -
                            {{ $p->item?->nama_item ?? '-' }}
                        </td>

                        <td>{{ $p->tgl_pinjam }}</td>

                        <td>
                            @if($p->status === 'Ditolak')
                            <span class="badge bg-danger">
                                {{ $p->status }}
                            </span>
                            @elseif($p->status === 'Disetujui')
                            <span class="badge bg-success">
                                {{ $p->status }}
                            </span>
                            @elseif($p->status === 'Dikembalikan')
                            <span class="badge bg-secondary">
                                {{ $p->status }}
                            </span>
                            @else
                            <span class="badge bg-info">
                                {{ $p->status }}
                            </span>
                            @endif
                        </td>

                        <td>
                            @if($p->status === 'Ditolak' && $p->alasan)
                            <small class="text-danger fw-semibold">
                                <strong>Alasan Penolakan:</strong><br>
                                {{ $p->alasan }}
                            </small>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5"
                            class="text-center text-muted">
                            Belum ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

            @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="p-3">
                {{ $data->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
            </div>
            @endif

        </div>
    </div>

</div>
@endsection