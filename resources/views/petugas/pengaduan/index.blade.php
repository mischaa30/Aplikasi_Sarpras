@extends('layouts.petugas')

@section('title', 'Data Pengaduan')

@section('content')

<h4 class="mb-4 fw-semibold">Daftar Pengaduan</h4>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $p->judul }}</td>
                            <td>{{ $p->user->username }}</td>
                            <td>{{ $p->kategori->nama_kategori }}</td>
                            <td>{{ $p->lokasi->nama_lokasi }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $p->status->nama_status_pengaduan }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{ $p->created_at->format('d-m-Y') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('petugas.pengaduan.show', $p->id) }}"
                                   class="btn btn-sm btn-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada pengaduan
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
