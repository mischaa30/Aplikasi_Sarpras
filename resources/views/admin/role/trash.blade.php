@extends('layouts.admin')

@section('title','Trash - Role')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Trash - Role</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-primary">Role Terhapus</span>
        <a href="{{ route('admin.role.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Role</th>
                    <th>Deleted At</th>
                    <th style="width:220px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $r)
                <tr>
                    <td>{{ $r->nama_role }}</td>
                    <td>{{ $r->deleted_at }}</td>
                    <td>
                        <form action="{{ route('admin.role.restore', $r->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm" type="submit">Restore</button>
                        </form>

                        <form action="{{ route('admin.role.forceDelete', $r->id) }}" method="POST" class="d-inline confirm-delete" data-confirm-message="Yakin hapus permanen?">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada role terhapus</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection