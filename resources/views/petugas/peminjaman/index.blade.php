@extends('layouts.petugas')

@section('title','Data Peminjaman')

@section('content')

<h3 class="mb-4 text-primary fw-semibold">
    Data Peminjaman
</h3>

<div class="card shadow-sm">
<div class="card-body">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div class="d-flex gap-2">

            <!-- SEARCH -->
            <form method="GET" class="d-flex" style="gap:.5rem">

                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       class="form-control form-control-sm"
                       placeholder="Cari peminjam, item, status...">

                <button class="btn btn-primary btn-sm">
                    Cari
                </button>

            </form>

            <!-- SCAN QR -->
            <a href="{{ route('petugas.pengembalian.scanner') }}"
               class="btn btn-info btn-sm">

                📱 Scan QR

            </a>

        </div>


        <!-- INFO PAGINATION -->
        @if($peminjaman instanceof \Illuminate\Pagination\LengthAwarePaginator)

            <small class="text-muted">

                Menampilkan
                {{ $peminjaman->firstItem() ?? 0 }} -
                {{ $peminjaman->lastItem() ?? 0 }}
                dari
                {{ $peminjaman->total() }}

            </small>

        @endif

    </div>


    <!-- TABLE -->
    <div class="table-responsive">

        <table class="table table-bordered table-striped align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>Peminjam</th>
                    <th>Sarpras</th>
                    <th>Tgl Pinjam</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th width="230">Aksi</th>
                </tr>
            </thead>


            <tbody>

            @forelse($peminjaman as $p)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $p->user->username ?? '-' }}
                </td>

                <td>
                    {{ $p->item?->nama_item ?? '-' }}
                </td>

                <td>
                    {{ $p->tgl_pinjam }}
                </td>

                <td>
                    {{ $p->tujuan }}
                </td>

                <td>

                    <span class="badge
                    {{ $p->status === 'Menunggu' ? 'bg-warning text-dark' :
                       ($p->status === 'Disetujui' ? 'bg-success' : 'bg-danger') }}">

                        {{ $p->status }}

                    </span>

                </td>


                <!-- AKSI -->
                <td>

                @if($p->status === 'Menunggu')

                    <div class="d-flex flex-column gap-1">

                        <a href="{{ route('petugas.inspeksi.form', [$p->id, 'sebelum']) }}"
                           class="btn btn-outline-primary btn-sm w-100">
                            Inspeksi Sebelum Pinjam
                        </a>

                        <form method="POST"
                              action="/petugas/peminjaman/{{ $p->id }}/setujui">

                            @csrf

                            <button class="btn btn-success btn-sm w-100">
                                Setujui
                            </button>

                        </form>


                        <form method="POST"
                              action="/petugas/peminjaman/{{ $p->id }}/tolak">

                            @csrf

                            <input type="text"
                                   name="alasan"
                                   class="form-control form-control-sm mb-1"
                                   placeholder="Alasan penolakan">

                            <button class="btn btn-danger btn-sm w-100">
                                Tolak
                            </button>

                        </form>

                    </div>


                @elseif($p->status === 'Disetujui')

                    <div class="d-flex gap-1">

                        <a href="{{ route('petugas.peminjaman.bukti',$p->id) }}"
                           class="btn btn-info btn-sm w-50">

                            Bukti

                        </a>


                        <a href="{{ route('petugas.pengembalian.create',$p->id) }}"
                           class="btn btn-warning btn-sm w-50">

                            Pendataan

                        </a>

                    </div>

                @else

                    -

                @endif

                </td>

            </tr>


            @empty

            <tr>
                <td colspan="7"
                    class="text-center text-muted">

                    Data peminjaman kosong

                </td>
            </tr>

            @endforelse

            </tbody>

        </table>


        <!-- PAGINATION -->
        @if($peminjaman instanceof \Illuminate\Pagination\LengthAwarePaginator)

        <div class="p-3">

            {{ $peminjaman->appends(request()->except('page'))
                ->links('pagination::bootstrap-5') }}

        </div>

        @endif

    </div>

</div>
</div>

@endsection
