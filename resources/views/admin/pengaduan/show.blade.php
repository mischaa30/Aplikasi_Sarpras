@extends('layouts.admin')

@section('title', 'Detail Pengaduan')

@section('content')

<h4 class="mb-4 fw-semibold">Detail Pengaduan</h4>

<div class="row">

    {{-- DETAIL --}}
    <div class="col-md-7">
        <div class="card mb-4">
            <div class="card-body">

                <h5 class="fw-bold mb-3">{{ $pengaduan->judul }}</h5>

                <p>{{ $pengaduan->deskripsi }}</p>

                <hr>

                <p><b>Lokasi:</b> {{ $pengaduan->lokasi->nama_lokasi ?? '-' }}</p>
                <p><b>Kategori:</b> {{ $pengaduan->kategori->nama_kategori }}</p>

                <p>
                    <b>Status:</b>
                    <span class="badge bg-info">
                        {{ $pengaduan->status->nama_status_pengaduan }}
                    </span>
                </p>

                @if($pengaduan->foto)
                <hr>
                <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                    class="img-fluid rounded"
                    style="max-width:350px">
                @endif

            </div>
        </div>
    </div>


    {{-- UPDATE STATUS --}}
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-body">

                <h6 class="fw-bold mb-3">Update Status</h6>

                <form action="{{ route('admin.pengaduan.status', $pengaduan->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <select name="status_pengaduan_id" class="form-select" required>
                            @foreach($status as $s)
                            <option value="{{ $s->id }}"
                                {{ $pengaduan->status_pengaduan_id == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_status_pengaduan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Update Status
                    </button>
                </form>

            </div>
        </div>


        {{-- TAMBAH CATATAN --}}
        <div class="card mb-4">
            <div class="card-body">

                <h6 class="fw-bold mb-3">Tambah Catatan</h6>

                <form action="{{ route('admin.pengaduan.catatan', $pengaduan->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <textarea name="catatan"
                            class="form-control"
                            rows="3"
                            placeholder="Tulis catatan..."
                            required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Simpan Catatan
                    </button>
                </form>

            </div>
        </div>

    </div>

</div>


{{-- LIST CATATAN --}}
<div class="card">
    <div class="card-body">

        <h6 class="fw-bold mb-3">Riwayat Catatan</h6>

        @forelse($pengaduan->catatan as $c)

        <div class="border rounded p-3 mb-3">

            <div class="d-flex justify-content-between mb-1">
                <b>{{ $c->user->name }}</b>
                <small class="text-muted">
                    {{ $c->created_at->format('d-m-Y H:i') }}
                </small>
            </div>

            <p class="mb-0">{{ $c->catatan }}</p>

        </div>

        @empty

        <p class="text-muted text-center">
            Belum ada catatan
        </p>

        @endforelse

    </div>
</div>
<br>
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>
</div>

@endsection