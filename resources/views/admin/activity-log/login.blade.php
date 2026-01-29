@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">

    <h3 class="mb-4">🔐 Activity Log Login</h3>

    {{-- FILTER TANGGAL --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Tanggal</label>
                    <input type="date"
                        name="tanggal"
                        value="{{ request('tanggal') }}"
                        class="form-control">
                </div>
                <div class="col-md-auto">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('activity.login') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->user->username ?? '-' }}</td>
                        <td>
                            @if ($d->aksi == 'login')
                            <span class="badge bg-success">LOGIN</span>
                            @elseif ($d->aksi == 'logout')
                            <span class="badge bg-danger">LOGOUT</span>
                            @else
                            <span class="badge bg-secondary">{{ strtoupper($d->aksi) }}</span>
                            @endif
                        </td>
                        <td>{{ $d->deskripsi }}</td>
                        <td>{{ $d->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
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