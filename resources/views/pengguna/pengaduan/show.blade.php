@extends('layouts.pengguna')

@section('content')
<div class="container-fluid mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary fw-semibold">
            📄 Detail Pengaduan
        </h3>
        <div class="d-flex gap-2">
            <a href="{{ route('pengguna.pengaduan.index') }}" class="btn btn-secondary btn-sm">
                Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- DETAIL KIRI -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-light fw-bold">
                    Informasi Pengaduan
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Judul</th>
                            <td>{{ $pengaduan->judul }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $pengaduan->kategori->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $pengaduan->lokasi->nama_lokasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Terkini</th>
                            <td>
                                <span class="badge bg-info fs-6">
                                    {{ $pengaduan->status->nama_status_pengaduan ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Diproses Oleh</th>
                            <td>{{ $pengaduan->diprosesOleh->username ?? '-' }} (Admin/Petugas)</td>
                        </tr>
                        <tr>
                            <th>Deskripsi Masalah</th>
                            <td>
                                <div class="p-2 border rounded bg-light">
                                    {{ $pengaduan->deskripsi }}
                                </div>
                            </td>
                        </tr>
                    </table>

                    @if($pengaduan->foto)
                    <div class="mt-3">
                        <strong>Lampiran Foto:</strong><br>
                        <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                             class="img-fluid rounded border mt-2"
                             style="max-height: 400px">
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN (CATATAN / KOMENTAR) -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    💬 Tindak Lanjut / Catatan
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    
                    @forelse($pengaduan->catatan as $c)
                    <div class="card mb-2 shadow-sm {{ $c->user_id == auth()->id() ? 'border-primary' : 'border-warning' }}">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between">
                                <strong class="small {{ $c->user_id == auth()->id() ? 'text-primary' : 'text-warning' }}">
                                    {{ $c->user->username ?? 'Unknown' }}
                                    @if($c->user->role->nama_role !== 'pengguna')
                                        (Admin/Petugas)
                                    @endif
                                </strong>
                                <span class="text-muted" style="font-size:10px">
                                    {{ $c->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="mb-0 mt-1 small">
                                {{ $c->catatan }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <small>Belum ada catatan tindak lanjut.</small>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
