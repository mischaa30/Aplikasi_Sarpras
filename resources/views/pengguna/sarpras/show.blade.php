@extends('layouts.pengguna')

@section('content')

<div class="container-fluid">

    <h4 class="mb-4 fw-semibold text-primary">
        📋 Daftar Item {{ $sarpras->nama_sarpras }}
    </h4>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Item</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($sarpras->items as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->nama_item }}</td>

                        <td>
                            {{ $item->kondisi->nama_kondisi ?? '-' }}
                        </td>

                        <td>
                            @if($item->peminjamanAktif)
                                <span class="badge bg-warning">
                                    {{ $item->peminjamanAktif->status }}
                                </span>
                            @else
                                <span class="badge bg-success">
                                    Tersedia
                                </span>
                            @endif
                        </td>

                        <td>

                            @if(
                                $item->kondisi->nama_kondisi == 'Baik'
                                && !$item->peminjamanAktif
                            )

                                <a href="{{ route('pengguna.peminjaman.create', $item->id) }}"
                                   class="btn btn-sm btn-success">
                                    Pinjam
                                </a>

                            @else
                                <span class="text-muted">-</span>
                            @endif

                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="5"
                            class="text-center text-muted">
                            Tidak ada item
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
