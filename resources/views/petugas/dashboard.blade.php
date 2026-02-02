@extends('layouts.petugas')

@section('content')

<div class="container-fluid mt-3">

    <h3 class="mb-4 text-primary fw-semibold">
        📊 Dashboard Petugas
    </h3>

    <div class="row g-4">

        <!-- Data Peminjaman -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">
                        📋 Data Peminjaman
                    </h5>
                    <p class="text-muted">
                        Lihat & proses peminjaman
                    </p>
                    <a href="{{ route('petugas.peminjaman.index') }}"
                       class="btn btn-primary btn-sm">
                        Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Pengembalian -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">
                        🔄 Pengembalian
                    </h5>
                    <p class="text-muted">
                        Input pengembalian barang
                    </p>
                    <a href="#"
                       class="btn btn-primary btn-sm">
                        Input Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Pengaduan -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">
                        ⚠️ Pengaduan
                    </h5>
                    <p class="text-muted">
                        Kelola laporan kerusakan
                    </p>
                    <a href="{{ route('admin.pengaduan.index') }}"
                       class="btn btn-primary btn-sm">
                        Kelola
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection