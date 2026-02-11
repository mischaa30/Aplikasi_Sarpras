@extends('layouts.admin')
@section('title','Tambah Checklist Inspeksi')
@section('content')

<h4 class="mb-3 fw-semibold">Tambah Checklist Inspeksi</h4>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inspeksi_items.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kategori Sarpras</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ ($selectedKategoriId ?? null) == $k->id ? 'selected' : '' }}>
                            {{ $k->parent?->nama_kategori ? $k->parent->nama_kategori.' / ' : '' }}{{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Checklist</label>
                <input type="text" name="nama_item" class="form-control" placeholder="Contoh: Layar, Kabel, Port HDMI" required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" id="aktif" name="aktif" class="form-check-input" value="1" checked>
                <label class="form-check-label" for="aktif">Aktif</label>
            </div>

            <div class="text-end">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.inspeksi_items.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
    </div>

@endsection
