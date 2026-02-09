@extends('layouts.admin')

@section('title', 'Activity Log')

@section('content')
<div class="container-fluid mt-4">

    <h3 class="mb-4">📋 Activity Log Peminjaman</h3>

    <a href="{{ route('admin.activity.export.pdf', request()->query())}}"
        class="btn btn-danger mb-3">

        📄 Export PDF
    </a>


    <!-- FILTER -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal"
                        value="{{ request('tanggal') }}"
                        class="form-control">
                </div>
                <div class="col-md-auto mt-4">
                    <button class="btn btn-primary px-4">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            Data Peminjaman
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Sarpras</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Tujuan</th>
                        <th>Disetujui Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->user->username ?? '-' }}</td>
                        <td>{{ $p->item?->nama_item ?? '-' }}</td>
                        <td>{{ $p->tgl_pinjam }}</td>
                        <td>{{ $p->tgl_kembali_actual ?? '-' }}</td>
                        <td>{{ $p->tujuan }}</td>
                        <td>{{ $p->approver->username ?? '-' }}</td>
                        <td>
                            @if($p->status === 'Dikembalikan' && $p->riwayatKondisi->count() > 0)
                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#detail-{{ $p->id }}" aria-expanded="false">
                                Lihat Detail
                            </button>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>

                    {{-- DETAIL PENGEMBALIAN --}}
                    @if($p->status === 'Dikembalikan' && $p->riwayatKondisi->count() > 0)
                    <tr class="collapse" id="detail-{{ $p->id }}">
                        <td colspan="8">
                            <div class="p-3 bg-light">
                                <h6 class="fw-bold mb-3">📦 Detail Pengembalian</h6>

                                @foreach($p->riwayatKondisi as $riwayat)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <small class="text-muted">Item:</small>
                                                <br>
                                                <strong>{{ $riwayat->item?->nama_item ?? '-' }}</strong>
                                            </div>

                                            <div class="col-md-2">
                                                <small class="text-muted">Kondisi:</small>
                                                <br>
                                                <span class="badge bg-info">
                                                    {{ $riwayat->kondisi?->nama_kondisi ?? '-' }}
                                                </span>
                                            </div>

                                            <div class="col-md-3">
                                                <small class="text-muted">Keterangan:</small>
                                                <br>
                                                <small>
                                                    @if($riwayat->deskripsi)
                                                    {{ $riwayat->deskripsi }}
                                                    @else
                                                    <span class="text-muted italic">-</span>
                                                    @endif
                                                </small>
                                            </div>

                                            <div class="col-md-3">
                                                @if($riwayat->foto)
                                                <small class="text-muted">📸 Foto:</small>
                                                <br>
                                                <img src="{{ asset('storage/' . $riwayat->foto) }}"
                                                    alt="Foto Kondisi"
                                                    class="img-thumbnail"
                                                    style="max-width: 150px; max-height: 150px; cursor: pointer;"
                                                    onclick="window.open('{{ asset('storage/' . $riwayat->foto) }}', '_blank')">
                                                @else
                                                <small class="text-muted">Tidak ada foto</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endif

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection