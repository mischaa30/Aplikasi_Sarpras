@extends('layouts.admin')

@section('title','Data Sarpras')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Data Sarpras</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center" style="gap:.5rem">
            <span class="fw-semibold text-primary">Daftar Sarpras</span>
            <form method="GET" class="d-flex" style="gap:.5rem; margin-left:.5rem">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari kode, nama, lokasi, kategori...">
                <button class="btn btn-primary btn-sm">Cari</button>
            </form>
        </div>

        <div class="d-flex align-items-center" style="gap:.75rem">
            @if($sarpras instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <small class="text-muted">Menampilkan {{ $sarpras->firstItem() ?? 0 }} - {{ $sarpras->lastItem() ?? 0 }} dari {{ $sarpras->total() }}</small>
            @endif

            <a href="{{ route('admin.sarpras.trash') }}" class="btn btn-secondary btn-sm">
                🗑️ Trash
            </a>

            <a href="{{ route('admin.sarpras.create') }}" class="btn btn-primary btn-sm">
                + Tambah Sarpras
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th style="width:220px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sarpras as $s)
                <tr>
                    <td>{{ $s->kode_sarpras }}</td>
                    <td>{{ $s->nama_sarpras }}</td>
                    <td>{{ $s->lokasi->nama_lokasi }}</td>
                    <td>
                        @if($s->kategori && $s->kategori->parent)
                        {{ $s->kategori->parent->nama_kategori }} - {{ $s->kategori->nama_kategori }}
                        @elseif($s->kategori)
                        {{ $s->kategori->nama_kategori }}
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $s->stok }}</td>
                    <td>
                        <div class="d-flex flex-column gap-1">

                            {{-- BARIS ATAS --}}
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.sarpras.show', $s->id) }}"
                                    class="btn btn-info btn-sm w-50">
                                    Detail
                                </a>

                                <a href="{{ route('admin.sarpras.item.create', $s->id) }}"
                                    class="btn btn-success btn-sm w-50">
                                    Tambah Unit
                                </a>
                            </div>

                            {{-- BARIS BAWAH --}}
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.sarpras.edit', $s->id) }}"
                                    class="btn btn-warning btn-sm w-50">
                                    Edit
                                </a>

                                <form action="{{ route('admin.sarpras.destroy', $s->id) }}"
                                    method="POST"
                                    class="w-50"
                                    onsubmit="return confirm('Yakin hapus sarpras ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm w-100">
                                        Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Data sarpras kosong
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($sarpras instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="p-3">
            {{ $sarpras->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@endsection