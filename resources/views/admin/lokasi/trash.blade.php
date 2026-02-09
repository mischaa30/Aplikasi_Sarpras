@extends('layouts.admin')

@section('title','Trash - Lokasi')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Trash - Lokasi</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center" style="gap:.5rem">
            <span class="fw-semibold text-primary">Lokasi Terhapus</span>
            <form method="GET" class="d-flex" style="gap:.5rem; margin-left: .5rem;">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari lokasi">
                <button class="btn btn-primary btn-sm">Cari</button>
            </form>
        </div>

        <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Lokasi</th>
                    <th>Deleted At</th>
                    <th style="width:220px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lokasi as $l)
                <tr>
                    <td>{{ $l->nama_lokasi }}</td>
                    <td>{{ $l->deleted_at }}</td>
                    <td>
                        <form action="{{ route('admin.lokasi.restore', $l->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm" type="submit">Restore</button>
                        </form>

                        <form action="{{ route('admin.lokasi.forceDelete', $l->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus permanen?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada lokasi terhapus</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($lokasi instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="p-3">
            {{ $lokasi->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@endsection