@extends('layouts.admin')

@section('title','Data User')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Data User</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-primary">Daftar User</span>

        <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm">
            + Tambah User
        </a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th style="width: 160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user as $u)
                    <tr>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->role->nama_role }}</td>
                        <td>
                            <a href="{{ route('admin.user.edit', $u->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.user.destroy', $u->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus user?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Data user kosong
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
