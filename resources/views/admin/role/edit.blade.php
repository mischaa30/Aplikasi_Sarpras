@extends('layouts.admin')

@section('title','Edit Role')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Edit Role</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <span class="fw-semibold text-primary">Form Edit Role</span>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.role.update', $role->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_role" class="form-label">Nama Role</label>
                <input type="text" class="form-control @error('nama_role') is-invalid @enderror" id="nama_role" name="nama_role" value="{{ old('nama_role', $role->nama_role) }}" required>
                @error('nama_role')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection