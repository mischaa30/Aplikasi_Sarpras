@extends('layouts.admin')

@section('title','Edit User')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Edit User</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Form Edit User
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('admin.user.update',$user->id) }}"
              class="confirm-submit">

            @csrf
            @method('PUT')

            {{-- Username --}}
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input
                    type="text"
                    name="username"
                    class="form-control"
                    value="{{ $user->username }}"
                    required>
            </div>

            {{-- Role --}}
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="id_role" class="form-select" required>
                    @foreach($role as $r)
                        <option value="{{ $r->id }}"
                            {{ $user->id_role == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_role }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Password Baru --}}
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Kosongkan jika tidak ingin ganti password">
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password baru">
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.user.index') }}"
                   class="btn btn-outline-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
