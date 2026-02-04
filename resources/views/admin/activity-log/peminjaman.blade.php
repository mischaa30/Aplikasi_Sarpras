@extends('layouts.admin')

@section('title', 'Activity Log')

@section('content')
<div class="container-fluid mt-4">

    <h3 class="mb-4">📋 Activity Log Peminjaman</h3>

    <a href="{{ route('admin.activity.export.pdf', request()->query())}}"
        class="btn btn-danger mb-3">

        📄 Export PDF
    </a>


    <!-- FILTER -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal"
                        value="{{ request('tanggal') }}"
                        class="form-control">
                </div>
                <div class="col-md-auto mt-4">
                    <button class="btn btn-primary px-4">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            Data Peminjaman
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Sarpras</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Tujuan</th>
                        <th>Disetujui Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->user->username ?? '-' }}</td>
                        <td>{{ $p->item?->nama_item ?? '-' }}</td>
                        <td>{{ $p->tgl_pinjam }}</td>
                        <td>{{ $p->tgl_kembali_actual ?? '-' }}</td>
                        <td>{{ $p->tujuan }}</td>
                        <td>{{ $p->approver->username ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection