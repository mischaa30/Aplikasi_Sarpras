@extends('layouts.admin')

@section('title','Trash - Kondisi')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Trash - Kondisi</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-primary">Kondisi Terhapus</span>
        <a href="{{ route('admin.kondisi.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Kondisi</th>
                    <th>Deleted At</th>
                    <th style="width:220px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kondisi as $k)
                <tr>
                    <td>{{ $k->nama_kondisi }}</td>
                    <td>{{ $k->deleted_at }}</td>
                    <td>
                        <form action="{{ route('admin.kondisi.restore', $k->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm" type="submit">Restore</button>
                        </form>

                        <form action="{{ route('admin.kondisi.forceDelete', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus permanen?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada kondisi terhapus</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection