@extends('layouts.admin')
@section('title','Edit Checklist Inspeksi')
@section('content')

<h4 class="mb-3 fw-semibold">Edit Checklist Inspeksi</h4>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inspeksi_items.update', $item->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Kategori Sarpras</label>
                <select name="kategori_id" class="form-select" required>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ $item->kategori_id == $k->id ? 'selected' : '' }}>
                            {{ $k->parent?->nama_kategori ? $k->parent->nama_kategori.' / ' : '' }}{{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Checklist</label>
                <input type="text" name="nama_item" class="form-control" value="{{ $item->nama_item }}" required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" id="aktif" name="aktif" class="form-check-input" value="1" {{ $item->aktif ? 'checked' : '' }}>
                <label class="form-check-label" for="aktif">Aktif</label>
            </div>

            <div class="text-end">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.inspeksi_items.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
    </div>

@endsection
