@extends('layouts.admin')

@section('title','Edit Lokasi')

@section('content')

<h4 class="mb-4 fw-semibold text-primary">
    ✏️ Edit Lokasi
</h4>

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.lokasi.update',$lokasi->id) }}">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Nama Lokasi
                </label>

                <input type="text"
                       name="nama_lokasi"
                       class="form-control"
                       value="{{ old('nama_lokasi',$lokasi->nama_lokasi) }}"
                       required>

                @error('nama_lokasi')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.lokasi.index') }}"
                   class="btn btn-secondary">
                    Batal
                </a>

                <button class="btn btn-primary">
                    Update
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
