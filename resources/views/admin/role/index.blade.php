@extends('layouts.admin')

@section('title','Data Role')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Data Role</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-primary">Daftar Role</span>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.role.trash') }}" class="btn btn-secondary btn-sm">
                🗑️ Trash
            </a>

            <a href="{{ route('admin.role.create') }}" class="btn btn-primary btn-sm">
                + Tambah Role
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Role</th>
                    <th style="width: 180px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $r)
                <tr>
                    <td>
                        {{ $r->nama_role }}
                    </td>
                    <td>
                        <a href="{{ route('admin.role.edit', $r->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.role.destroy', $r->id) }}" method="POST" class="d-inline confirm-delete" data-confirm-message="Yakin hapus role?">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center text-muted">Data role kosong</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection