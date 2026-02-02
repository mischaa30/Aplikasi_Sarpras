@extends('layouts.pengguna')

@section('content')

<div class="container-fluid mt-3">

    <h3 class="mb-4 text-primary fw-semibold">
        📊 Dashboard Pengguna
    </h3>

    <div class="row g-4">

        <!-- Riwayat Pinjaman -->
        <div class="col-md-6">

            <div class="card shadow-sm h-100">

                <div class="card-body text-center">

                    <h5 class="card-title text-primary">
                        📦 Riwayat Pinjaman
                    </h5>

                    <p class="text-muted">
                        Lihat semua data peminjaman barang
                    </p>

                    <a href="{{ route('pengguna.peminjaman.index') }}"
                        class="btn btn-primary btn-sm">
                        Lihat Data
                    </a>

                </div>
            </div>

        </div>

        <!-- Riwayat Pengaduan -->
        <div class="col-md-6">

            <div class="card shadow-sm h-100">

                <div class="card-body text-center">

                    <h5 class="card-title text-primary">
                        📝 Riwayat Pengaduan
                    </h5>

                    <p class="text-muted">
                        Lihat semua laporan pengaduan kamu
                    </p>

                    <a href="{{ route('pengguna.pengaduan.index') }}"
                        class="btn btn-primary btn-sm">
                        Lihat Data
                    </a>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection