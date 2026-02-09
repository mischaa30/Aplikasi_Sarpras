@extends('layouts.admin')

@section('title','Tambah Kategori')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Tambah Kategori</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Form Tambah Kategori
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.kategori.store') }}"  class="confirm-submit">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input
                    type="text"
                    name="nama_kategori"
                    class="form-control"
                    placeholder="Masukkan nama kategori"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Parent</label>
                <select name="parent_id" class="form-select">
                    <option value="">-- Root (Kategori Utama) --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
