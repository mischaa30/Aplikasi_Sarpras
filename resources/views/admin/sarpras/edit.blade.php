@extends('layouts.admin')

@section('title','Edit Sarpras')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Edit Sarpras</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Form Edit Sarpras
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.sarpras.update', $sarpras->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kode Sarpras</label>
                <input name="kode_sarpras" class="form-control"
                       value="{{ $sarpras->kode_sarpras }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Sarpras</label>
                <input name="nama_sarpras" class="form-control"
                       value="{{ $sarpras->nama_sarpras }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <select name="id_lokasi" class="form-select">
                    @foreach($lokasi as $l)
                        <option value="{{ $l->id }}"
                            {{ $sarpras->id_lokasi == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori_id" class="form-select">
                    @foreach ($kategori as $c)
                        <option value="{{ $c->id }}"
                            {{ $sarpras->kategori_id == $c->id ? 'selected' : '' }}>
                            {{ optional($c->parent)->nama_kategori }} - {{ $c->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.sarpras.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection
