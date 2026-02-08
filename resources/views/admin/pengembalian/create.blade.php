@extends('layouts.admin')

@section('title', 'Form Pengembalian')

@section('content')

<h4 class="mb-4 fw-semibold">Form Pengembalian Barang</h4>

<div class="card">
    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.pengembalian.store') }}"
              enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

            {{-- TANGGAL KEMBALI --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Tanggal Kembali
                </label>

                <input type="date"
                       name="tgl_kembali_actual"
                       class="form-control"
                       required>
            </div>

            <hr>

            {{-- LIST BARANG --}}
            @foreach($peminjaman->detail as $i => $d)

                <div class="border rounded p-3 mb-4">

                    <h6 class="fw-bold mb-3">
                        {{ $d->sarprasItem?->nama_item ?? '-' }}
                    </h6>

                    <input type="hidden"
                           name="detail_id[]"
                           value="{{ $d->id }}">

                    {{-- KONDISI --}}
                    <div class="mb-3">
                        <label class="form-label">Kondisi Barang Saat Kembali</label>

                        <select name="kondisi_sarpras_id[]"
                                class="form-select"
                                required>

                            <option value="">-- Pilih Kondisi --</option>

                            @foreach($listKondisi as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama_kondisi }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- KETERANGAN --}}
                    <div class="mb-3">
                        <label class="form-label">Keterangan Pengembalian</label>

                        <textarea name="deskripsi[]"
                                  class="form-control"
                                  rows="2"
                                  placeholder="Keterangan kondisi alat saat pengembalian (opsional)"></textarea>
                    </div>

                    {{-- FOTO --}}
                    <div class="mb-3">
                        <label class="form-label">Foto Kondisi Alat</label>

                        <input type="file"
                               name="foto[]"
                               class="form-control"
                               accept="image/*">
                        <small class="text-muted">Format: JPG, PNG. Ukuran maksimal: 5MB</small>
                    </div>

                </div>

            @endforeach


            {{-- TOMBOL --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">
                    Simpan Pengembalian
                </button>
            </div>

        </form>

    </div>
</div>
<br>
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>
</div>

@endsection
