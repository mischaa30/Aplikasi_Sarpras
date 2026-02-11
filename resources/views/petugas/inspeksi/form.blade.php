@extends('layouts.petugas')
@section('title','Inspeksi ' . $tipe)
@section('content')

<h4 class="mb-3 fw-semibold">Inspeksi {{ $tipe }} Peminjaman</h4>

<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div><span class="text-muted">Peminjam</span><br>{{ $peminjaman->user->username ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <div><span class="text-muted">Item</span><br>{{ $peminjaman->item?->nama_item ?? ($peminjaman->detail->pluck('sarprasItem.nama_item')->join(', ') ?: '-') }}</div>
            </div>
        </div>
    </div>
 </div>

<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-2">
            <div class="col-12 col-md-6 mb-2 mb-md-0">
                <div class="d-grid d-md-inline">
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <span class="text-muted">Kategori: {{ $peminjaman->item?->sarpras?->kategori?->nama_kategori ?? $peminjaman->detail->first()?->sarpras?->kategori?->nama_kategori }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('petugas.inspeksi.store', [$peminjaman->id, strtolower($tipe)]) }}">
            @csrf
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:40%">Checklist</th>
                            <th style="width:25%">Kondisi</th>
                            <th style="width:35%">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checklist as $c)
                        @php
                            $existingRow = $existing?->hasil->firstWhere('inspeksi_item_id', $c->id);
                        @endphp
                        <tr>
                            <td>
                                {{ $c->nama_item }}
                                <input type="hidden" name="item_id[]" value="{{ $c->id }}">
                            </td>
                            <td>
                                <select name="kondisi_id[]" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach($listKondisi as $k)
                                        <option value="{{ $k->id }}" {{ ($existingRow && $existingRow->kondisi_sarpras_id == $k->id) ? 'selected' : '' }}>
                                            {{ $k->nama_kondisi }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="catatan[]" class="form-control" value="{{ $existingRow->catatan ?? '' }}" placeholder="Opsional">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-grid d-md-flex justify-content-md-end">
                <button class="btn btn-primary">Simpan Inspeksi {{ $tipe }}</button>
            </div>
        </form>
    </div>
</div>

@endsection
