@extends('layouts.admin')

@section('title','Tambah Unit Barang')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Tambah Unit Barang</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Form Tambah Unit Barang
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.sarpras.item.store', $sarpras->id) }}"  class="confirm-submit">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Unit</label>
                <input name="nama_item" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kondisi</label>
                <select name="kondisi_sarpras_id" class="form-select">
                    @foreach($listKondisi as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kondisi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.sarpras.index', $sarpras->id) }}"
                   class="btn btn-outline-secondary">
                    Batal
                </a>
                <button class="btn btn-primary">
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
