@extends('layouts.admin')

@section('title','Data Kondisi')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Data Kondisi</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-primary">Daftar Kondisi</span>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.kondisi.trash') }}" class="btn btn-secondary btn-sm">
                🗑️ Trash
            </a>

            <a href="{{ route('admin.kondisi.create') }}" class="btn btn-primary btn-sm">
                + Tambah Kondisi
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Kondisi</th>
                    <th style="width: 180px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kondisi as $k)
                <tr>
                    <td>
                        {{ $k->nama_kondisi }}
                    </td>
                    <td>
                        <a href="{{ route('admin.kondisi.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.kondisi.destroy', $k->id) }}" method="POST" class="d-inline confirm-delete" data-confirm-message="Yakin hapus kondisi?">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center text-muted">Data kondisi kosong</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection