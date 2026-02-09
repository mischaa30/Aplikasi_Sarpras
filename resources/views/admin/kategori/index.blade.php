@extends('layouts.admin')

@section('title','Data Kategori')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Data Kategori</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center" style="gap:.5rem">
            <span class="fw-semibold text-primary">Daftar Kategori</span>
            <form method="GET" class="d-flex" style="gap:.5rem; margin-left:.5rem">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari kategori atau subkategori...">
                <button class="btn btn-primary btn-sm">Cari</button>
            </form>
        </div>

        <div class="d-flex align-items-center" style="gap:.75rem">
            @if($kategori instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <small class="text-muted">Menampilkan {{ $kategori->firstItem() ?? 0 }} - {{ $kategori->lastItem() ?? 0 }} dari {{ $kategori->total() }}</small>
            @endif

            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
                + Tambah Kategori
            </a>
        </div>
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

        @if($kategori instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="p-3">
            {{ $kategori->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@endsection