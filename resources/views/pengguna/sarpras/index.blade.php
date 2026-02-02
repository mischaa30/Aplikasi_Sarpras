@extends('layouts.pengguna')

@section('content')

<div class="container-fluid">

    <h4 class="mb-4 fw-semibold text-primary">
        📦 Daftar Sarpras
    </h4>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Jenis Sarpras</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($sarpras as $s)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->nama_sarpras }}</td>
                        <td>{{ $s->stok }}</td>

                        <td>
                            <a href="{{ route('pengguna.sarpras.show', $s->id) }}"
                               class="btn btn-sm btn-primary">
                                Lihat
                            </a>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4"
                            class="text-center text-muted">
                            Data kosong
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
