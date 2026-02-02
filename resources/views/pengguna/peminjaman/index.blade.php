@extends('layouts.pengguna')

@section('content')
<div class="container-fluid mt-3">

    <h3 class="mb-4 text-primary fw-semibold">
        📋 Pinjaman Saya
    </h3>

    <div class="card">

        <div class="card-header bg-primary text-white">
            Riwayat Peminjaman
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Barang</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $p->item?->sarpras?->nama_sarpras ?? '-' }}
                            -
                            {{ $p->item?->nama_item ?? '-' }}
                        </td>

                        <td>{{ $p->tgl_pinjam }}</td>

                        <td>
                            <span class="badge bg-info">
                                {{ $p->status }}
                            </span>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4"
                            class="text-center text-muted">
                            Belum ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
