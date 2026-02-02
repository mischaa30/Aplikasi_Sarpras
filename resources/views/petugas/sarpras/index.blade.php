@extends('layouts.petugas')

@section('title','Data Sarpras')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">Data Sarpras</h3>

<div class="card shadow-sm">

    <div class="card-header bg-white">
        <span class="fw-semibold text-primary">Daftar Sarpras</span>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Kategori</th>
                </tr>
            </thead>

            <tbody>
                @forelse($sarpras as $s)
                <tr>
                    <td>{{ $s->kode_sarpras }}</td>

                    <td>{{ $s->nama_sarpras }}</td>

                    <td>{{ $s->lokasi->nama_lokasi ?? '-' }}</td>

                    <td>
                        @if($s->kategori && $s->kategori->parent)
                            {{ $s->kategori->parent->nama_kategori }}
                            -
                            {{ $s->kategori->nama_kategori }}
                        @elseif($s->kategori)
                            {{ $s->kategori->nama_kategori }}
                        @else
                            -
                        @endif
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Data sarpras kosong
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection
