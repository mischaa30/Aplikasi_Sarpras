@extends('layouts.pengguna')

@section('content')
<div class="container-fluid mt-3">

    <!-- Judul -->
    <h3 class="mb-4 text-primary fw-semibold">
        📂 Kategori: {{ $kategori->nama_kategori }}
    </h3>


    <!-- SUB KATEGORI -->
    @if($subKategori->count())
    <div class="card mb-4">

        <div class="card-header bg-primary text-white">
            Sub Kategori
        </div>

        <div class="card-body">

            <ul class="list-group">

                @foreach($subKategori as $s)
                <li class="list-group-item d-flex justify-content-between align-items-center">

                    {{ $s->nama_kategori }}

                    <a href="{{ route('pengguna.kategori.show', $s->id) }}"
                       class="btn btn-sm btn-outline-primary">
                        Lihat
                    </a>

                </li>
                @endforeach

            </ul>

        </div>
    </div>
    @endif


    <!-- SARPRAS -->
    @if($sarpras->count())
    <div class="card">

        <div class="card-header bg-primary text-white">
            Daftar Sarpras
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Sarpras</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sarpras as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->nama_sarpras }}</td>
                        <td>
                            <a href="{{ route('pengguna.sarpras.show', $s->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
    @endif

</div>
@endsection
