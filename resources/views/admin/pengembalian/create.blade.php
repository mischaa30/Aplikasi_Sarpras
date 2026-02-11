@extends('layouts.admin')

@section('title', 'Form Pengembalian')

@section('content')

<h4 class="mb-4 fw-semibold">Form Pengembalian Barang</h4>

<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.inspeksi.form', [$peminjaman->id, 'sesudah']) }}"
               class="btn btn-outline-primary">
                Inspeksi Sesudah Pinjam
            </a>
        </div>

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
                    id="tgl_kembali_actual"
                    class="form-control"
                    required>
                <div class="form-text text-danger" id="tglKembaliError" style="display:none"></div>
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
                        <option value="{{ $k->id }}" {{ ($prefillKondisiId ?? null) == $k->id ? 'selected' : '' }}>
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tglKembali = document.getElementById('tgl_kembali_actual');
                const tglKembaliError = document.getElementById('tglKembaliError');
                if (tglKembali) {
                    tglKembali.addEventListener('change', function() {
                        const val = this.value;
                        const date = new Date(val);
                        const day = date.getDay();
                        if (day === 0 || day === 6) {
                            tglKembaliError.style.display = '';
                            tglKembaliError.textContent = 'Tanggal kembali tidak boleh hari Sabtu atau Minggu.';
                            this.value = '';
                        } else {
                            tglKembaliError.style.display = 'none';
                        }
                    });
                }
                // Prevent submit if tglKembali is weekend
                const form = tglKembali?.form;
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const val = tglKembali.value;
                        const date = new Date(val);
                        const day = date.getDay();
                        if (day === 0 || day === 6) {
                            tglKembaliError.style.display = '';
                            tglKembaliError.textContent = 'Tanggal kembali tidak boleh hari Sabtu atau Minggu.';
                            e.preventDefault();
                        }
                    });
                }
            });
        </script>

    </div>
</div>
<br>
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>
</div>

@endsection
