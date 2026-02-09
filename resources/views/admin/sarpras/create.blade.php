@extends('layouts.admin')

@section('title','Tambah Sarpras')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Tambah Sarpras</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Form Tambah Sarpras
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.sarpras.store') }}" class="confirm-submit">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Sarpras</label>
                <input name="nama_sarpras" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <select name="id_lokasi" class="form-select" required>
                    @foreach($lokasi as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Sub Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Sub Kategori --</option>
                    @foreach ($childKategori as $c)
                        <option value="{{ $c->id }}">
                           {{ optional($c->parent)->nama_kategori }} - {{ $c->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.sarpras.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
