@extends('layouts.admin')

@section('title','Edit User')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Edit User</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Form Edit User
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.user.update',$user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input
                    name="username"
                    class="form-control"
                    value="{{ $user->username }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="id_role" class="form-select">
                    @foreach($role as $r)
                        <option value="{{ $r->id }}"
                            {{ $user->id_role == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_role }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
                    Kembali
                </a>
                <button class="btn btn-primary">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
