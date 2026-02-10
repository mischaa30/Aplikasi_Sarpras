@extends('layouts.pengguna')

@section('content')
<div class="container-fluid mt-3">

    <div class="d-flex justify-content-between mb-3">

        <h3 class="text-primary fw-semibold">
            📋 Riwayat Pengaduan
        </h3>

        <a href="{{ route('pengguna.pengaduan.create') }}"
            class="btn btn-primary">
            + Buat Pengaduan
        </a>

    </div>


    <div class="card">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Data Pengaduan</span>

            <form method="GET" class="d-flex" style="gap:.5rem">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari judul, deskripsi, kategori, lokasi...">
                <button class="btn btn-light btn-sm">Cari</button>
            </form>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $p)
                        <tr>
                            <td>{{ $p->judul }}</td>
                            <td>{{ $p->deskripsi }}</td>

                            <td>
                                {{ $p->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td>
                                {{ $p->lokasi->nama_lokasi ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $p->status->nama_status_pengaduan ?? '-' }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if($p->foto)
                                <img src="{{ asset('storage/' . $p->foto) }}"
                                    width="80"
                                    class="rounded">
                                @else
                                -
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pengguna.pengaduan.show', $p->id) }}"
                                   class="btn btn-sm btn-info text-white">
                                   Detail
                                </a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6"
                                class="text-center text-muted">
                                Belum ada pengaduan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

                @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="p-3">
                    {{ $data->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                </div>
                @endif

            </div>

        </div>
    </div>


</div>
@endsection