@extends('layouts.admin')

@section('title','Trash - Kategori')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Trash - Kategori</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center" style="gap:.5rem">
            <span class="fw-semibold text-primary">Kategori Terhapus</span>
            <form method="GET" class="d-flex" style="gap:.5rem; margin-left: .5rem;">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari kategori">
                <button class="btn btn-primary btn-sm">Cari</button>
            </form>
        </div>

        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Kategori</th>
                    <th>Deleted At</th>
                    <th style="width:220px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $k)
                <tr>
                    <td>{{ $k->nama_kategori }}</td>
                    <td>{{ $k->deleted_at }}</td>
                    <td>
                        <form action="{{ route('admin.kategori.restore', $k->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm" type="submit">Restore</button>
                        </form>

                        <form action="{{ route('admin.kategori.forceDelete', $k->id) }}" method="POST" class="d-inline confirm-delete" data-confirm-message="Yakin hapus permanen?">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada kategori terhapus</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($kategori instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="p-3">
            {{ $kategori->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@endsection