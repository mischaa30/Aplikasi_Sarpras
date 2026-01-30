@extends('layouts.admin')

@section('title','Tambah User')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Tambah User</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Form Tambah User
    </div>

    <div class="card-body">
        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="id_role" class="form-select">
                    @foreach($role as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_role }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
                    Kembali
                </a>
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
