@extends('layouts.pengguna')

@section('content')
<div class="container-fluid mt-3">

    <h3 class="mb-4 text-primary fw-semibold">
        📂 Daftar Kategori Sarpras
    </h3>

    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Data Kategori</span>

            <form method="GET" class="d-flex" style="gap:.5rem">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama kategori...">
                <button class="btn btn-light btn-sm">Cari</button>
            </form>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Kategori</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($kategori as $k)
                    <tr>
                        <td>@if($kategori instanceof \Illuminate\Pagination\LengthAwarePaginator){{ $kategori->firstItem() + $loop->index }}@else{{ $loop->iteration }}@endif</td>
                        <td>{{ $k->nama_kategori }}</td>
                        <td>
                            <a href="{{ route('pengguna.kategori.show', $k->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Data kosong
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

            @if($kategori instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="p-3">
                {{ $kategori->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
            </div>
            @endif

        </div>
    </div>

</div>
@endsection