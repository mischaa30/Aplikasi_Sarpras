@extends('layouts.admin')

@section('title','Edit Unit Barang')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Edit Unit Barang</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Form Edit Unit Barang
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.sarpras.item.update', $item->id) }}" class="confirm-submit">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Unit</label>
                <input name="nama_item"
                    class="form-control"
                    value="{{ $item->nama_item }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kondisi</label>
                <select name="kondisi_sarpras_id" class="form-select">
                    @foreach($listKondisi as $k)
                    <option value="{{ $k->id }}"
                        {{ $item->kondisi_sarpras_id == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kondisi }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.sarpras.show', $item->sarpras_id) }}"
                    class="btn btn-outline-secondary">
                    Batal
                </a>
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection