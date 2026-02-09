@extends('layouts.admin')

@section('title','Edit Kategori')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Edit Kategori</h3>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold text-primary">
        Form Edit Kategori
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.kategori.update', $kategori->id) }}"  class="confirm-submit">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input
                    type="text"
                    name="nama_kategori"
                    class="form-control"
                    value="{{ $kategori->nama_kategori }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Parent</label>
                <select name="parent_id" class="form-select">
                    <option value="">-- Root --</option>
                    @foreach($parent as $p)
                        <option
                            value="{{ $p->id }}"
                            {{ $kategori->parent_id == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
