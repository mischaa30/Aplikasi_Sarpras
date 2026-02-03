@extends('layouts.admin')

@section('title','Data Lokasi')

@section('content')

<h4 class="mb-4 fw-semibold text-primary">
    📍 Data Lokasi
</h4>

<div class="card shadow-sm">

    <div class="card-header bg-white d-flex justify-content-between">
        <div class="d-flex align-items-center" style="gap:.5rem">
            <span class="fw-semibold">Daftar Lokasi</span>
            <form method="GET" class="d-flex" style="gap:.5rem; margin-left:.5rem">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama lokasi...">
                <button class="btn btn-primary btn-sm">Cari</button>
            </form>
        </div>

        <div class="d-flex align-items-center" style="gap:.75rem">
            @if($lokasi instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <small class="text-muted">Menampilkan {{ $lokasi->firstItem() ?? 0 }} - {{ $lokasi->lastItem() ?? 0 }} dari {{ $lokasi->total() }}</small>
            @endif

            <a href="{{ route('admin.lokasi.create') }}"
                class="btn btn-primary btn-sm">
                + Tambah Lokasi
            </a>
        </div>
    </div>

    <div class="card-body p-0">

        <table class="table table-bordered table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th width="80">No</th>
                    <th>Nama Lokasi</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($lokasi as $l)
                <tr>
                    <td>@if($lokasi instanceof \Illuminate\Pagination\LengthAwarePaginator){{ $lokasi->firstItem() + $loop->index }}@else{{ $loop->iteration }}@endif</td>
                    <td>{{ $l->nama_lokasi }}</td>
                    <td>

                        <a href="{{ route('admin.lokasi.edit',$l->id) }}"
                            class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('admin.lokasi.destroy',$l->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        Data lokasi kosong
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

        @if($lokasi instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="p-3">
            {{ $lokasi->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</div>

@endsection