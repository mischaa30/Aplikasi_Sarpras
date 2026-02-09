@extends('layouts.admin')

@section('title','Trash - Sarpras')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Trash - Sarpras</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center" style="gap:.5rem">
            <span class="fw-semibold text-primary">Sarpras Terhapus</span>
            <form method="GET" class="d-flex" style="gap:.5rem; margin-left: .5rem;">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama sarpras">
                <button class="btn btn-primary btn-sm">Cari</button>
            </form>
        </div>

        <a href="{{ route('admin.sarpras.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Deleted At</th>
                    <th style="width:220px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sarpras as $s)
                <tr>
                    <td>{{ $s->kode_sarpras }}</td>
                    <td>{{ $s->nama_sarpras }}</td>
                    <td>{{ $s->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $s->lokasi->nama_lokasi ?? '-' }}</td>
                    <td>{{ $s->deleted_at }}</td>
                    <td>
                        <form action="{{ route('admin.sarpras.restore', $s->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm" type="submit">Restore</button>
                        </form>

                        <form action="{{ route('admin.sarpras.forceDelete', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus permanen?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada sarpras terhapus</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($sarpras instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="p-3">
            {{ $sarpras->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@endsection