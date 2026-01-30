@extends('layouts.admin')

@section('title','Data Kategori')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Data Kategori</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-primary">Daftar Kategori</span>

        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
            + Tambah Kategori
        </a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Kategori</th>
                    <th>Parent</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($kategori as $parent)
                    {{-- PARENT --}}
                    <tr>
                        <td class="fw-semibold">
                            {{ $parent->nama_kategori }}
                        </td>
                        <td>
                            <span class="badge bg-secondary">Root</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.kategori.edit', $parent->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.kategori.destroy', $parent->id) }}"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- CHILD --}}
                    @foreach($parent->children as $child)
                        <tr>
                            <td class="ps-4">
                                — {{ $child->nama_kategori }}
                            </td>
                            <td>
                                {{ $parent->nama_kategori }}
                            </td>
                            <td>
                                <a href="{{ route('admin.kategori.edit', $child->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.kategori.destroy', $child->id) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Data kategori belum tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
