@extends('layouts.admin')

@section('title','Detail Sarpras')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Detail Sarpras</h3>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <p class="mb-1"><b>Nama:</b> {{ $sarpras->nama_sarpras }}</p>
        <p class="mb-1"><b>Lokasi:</b> {{ $sarpras->lokasi->nama_lokasi }}</p>
        <p class="mb-0"><b>Kategori:</b> {{ $sarpras->kategori->nama_kategori }}</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Daftar Unit Barang
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Unit</th>
                    <th>Kondisi</th>
                    <th style="width:140px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sarpras->items as $item)
                <tr>
                    <td>{{ $item->nama_item }}</td>
                    <td>{{ $item->kondisi->nama_kondisi }}</td>
                    <td>
                        <a href="{{ route('admin.sarpras.item.edit', $item->id) }}"
                            class="btn btn-warning btn-sm">Edit</a>

                        <form method="POST"
                            action="{{ route('admin.sarpras.item.destroy', $item->id) }}"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus unit ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Unit belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('admin.sarpras.index', $sarpras->id) }}"
        class="btn btn-outline-secondary">
        Kembali
    </a>
</div>

@endsection