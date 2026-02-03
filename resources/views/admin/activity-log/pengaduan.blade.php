@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">

    <h3 class="mb-4">📋 Activity Log Pengaduan</h3>

    <!-- FILTER -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label">Status Pengaduan</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        @foreach($listStatus as $status)
                        <option value="{{ $status->nama_status_pengaduan }}"
                            {{ request('status') == $status->nama_status_pengaduan ? 'selected' : '' }}>
                            {{ $status->nama_status_pengaduan }}
                        </option>
                        @endforeach
                    </select>
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
            Data Pengaduan
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Diproses Oleh</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->user->username ?? '-' }}</td>
                        <td>{{ $d->judul }}</td>

                        {{-- STATUS --}}
                        <td>
                            @switch($d->status->nama_status_pengaduan ?? '')

                                @case('Belum Di tindak lanjuti')
                                    <span class="badge bg-secondary">
                                        Belum Ditindaklanjuti
                                    </span>
                                @break

                                @case('Sedang Diproses')
                                    <span class="badge bg-warning text-dark">
                                        Sedang Diproses
                                    </span>
                                @break

                                @case('Selesai')
                                    <span class="badge bg-success">
                                        Selesai
                                    </span>
                                @break

                                @case('Ditutup')
                                    <span class="badge bg-dark">
                                        Ditutup
                                    </span>
                                @break

                                @default
                                    <span class="badge bg-info">
                                        {{ $d->status->nama_status_pengaduan ?? '-' }}
                                    </span>

                            @endswitch
                        </td>

                        {{-- TANGGAL --}}
                        <td>{{ $d->created_at->format('d-m-Y') }}</td>

                        {{-- DIPROSES --}}
                        <td>
                            {{ $d->diprosesOleh->username ?? '-' }}
                        </td>

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
