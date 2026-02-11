@extends('layouts.admin')

@section('title','Checklist Inspeksi')
@section('content')

<h4 class="mb-3 fw-semibold">Checklist Inspeksi per Kategori</h4>

<div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <form method="GET" class="d-flex align-items-center" style="gap:.5rem">
            <select name="kategori_id" class="form-select form-select-sm" style="width:280px">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ $kategoriId == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                    @foreach($k->children as $c)
                        <option value="{{ $c->id }}" {{ $kategoriId == $c->id ? 'selected' : '' }}>
                            — {{ $c->nama_kategori }}
                        </option>
                    @endforeach
                @endforeach
            </select>
            <button class="btn btn-primary btn-sm">Filter</button>
        </form>

        <a href="{{ route('admin.inspeksi_items.create') }}" class="btn btn-success btn-sm">
            Tambah Checklist
        </a>
    </div>
</div>

@php
    $grouped = $items->groupBy('kategori_id');
@endphp

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
    @forelse($grouped as $katId => $rows)
        @php
            $katName = $rows->first()->kategori?->nama_kategori ?? 'Tanpa Kategori';
        @endphp
        <div class="col">
            <div class="card mb-3 h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>{{ $katName }}</span>
                    <a href="{{ route('admin.inspeksi_items.create') }}?kategori_id={{ $katId }}" class="btn btn-light btn-sm">Tambah</a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Checklist</th>
                                <th class="text-center" style="width:80px">Aktif</th>
                                <th style="width:140px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $it)
                            <tr>
                                <td>{{ $it->nama_item }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $it->aktif ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $it->aktif ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.inspeksi_items.edit', $it->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.inspeksi_items.destroy', $it->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus checklist ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($rows->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada checklist</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Belum ada checklist</div>
        </div>
    @endforelse
</div>

@endsection
