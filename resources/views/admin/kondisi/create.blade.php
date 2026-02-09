@extends('layouts.admin')

@section('title','Tambah Kondisi')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Tambah Kondisi</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <span class="fw-semibold text-primary">Form Tambah Kondisi</span>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.kondisi.store') }}">
            @csrf

            <div class="mb-3">
                <label for="nama_kondisi" class="form-label">Nama Kondisi</label>
                <input type="text" class="form-control @error('nama_kondisi') is-invalid @enderror" id="nama_kondisi" name="nama_kondisi" value="{{ old('nama_kondisi') }}" required>
                @error('nama_kondisi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kondisi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection