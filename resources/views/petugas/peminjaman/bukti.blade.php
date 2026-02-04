@extends('layouts.petugas')

@section('title','Struk Peminjaman')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Struk Peminjaman</h3>

<div class="card shadow-sm" style="max-width:400px">
    <div class="card-body">

        <div class="text-center fw-semibold mb-2">
            CETAK BUKTI PEMINJAMAN SARPRAS<br>
            SMKN 1 BOYOLANGU
        </div>

        <hr>

        <table class="table table-sm table-borderless mb-2">
            <tr>
                <th>Peminjam</th>
                <td>{{ $peminjaman->user->username ?? '-' }}</td>
            </tr>
            <tr>
                <th>Item</th>
                <td>{{ $peminjaman->item?->nama_item ?? '-' }}</td>
            </tr>
            <tr>
                <th>Pinjam</th>
                <td>{{ $peminjaman->tgl_pinjam }}</td>
            </tr>
            <tr>
                <th>Tujuan</th>
                <td>{{ $peminjaman->tujuan }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-primary">
                        {{ $peminjaman->status }}
                    </span>
                </td>
            </tr>
        </table>

        <hr>

        <div class="text-center">
            {!! QrCode::size(120)->generate(json_encode($qrData)) !!}
            <div class="small text-muted">Scan untuk verifikasi</div>
        </div>

    </div>
</div>

<div class="d-flex justify-content-end gap-2 no-print">
    <button type="button" class="btn btn-primary" onclick="window.print()">Cetak</button>
    <a href="{{ route('petugas.peminjaman.index') }}"
        class="btn btn-outline-secondary">
        Kembali
    </a>
</div>

@endsection
