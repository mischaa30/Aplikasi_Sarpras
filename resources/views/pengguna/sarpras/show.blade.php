@extends('layouts.pengguna')

@section('content')

<div class="container-fluid">

    <h4 class="mb-4 fw-semibold text-primary">
        📋 Daftar Item {{ $sarpras->nama_sarpras }}
    </h4>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="GET" class="d-flex" style="gap:.5rem">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama item atau kondisi...">
                    <button class="btn btn-light btn-sm">Cari</button>
                </form>
            </div>

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
                                Dipinjam
                            </span>
                            @else
                            <span class="badge bg-success">
                                Tersedia
                            </span>
                            @endif
                        </td>


                        <td>

                            @if(
                            in_array($item->kondisi->nama_kondisi, ['Baik','Rusak Ringan'])
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