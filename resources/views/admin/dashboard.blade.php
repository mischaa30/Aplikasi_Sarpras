@extends('layouts.admin')

@section('title','Dashboard Admin')

@section('content')

<div class="container-fluid mt-3">

    <h3 class="mb-4 text-primary fw-semibold">
        📊 Dashboard Admin
    </h3>

    <div class="row g-4">

        {{-- User --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">
                        👥 Data User
                    </h5>
                    <p class="text-muted">
                        Kelola data pengguna sistem
                    </p>
                    <a href="{{ route('admin.user.index') }}"
                       class="btn btn-primary btn-sm">
                        Buka Menu
                    </a>
                </div>
            </div>
        </div>

        {{-- Sarpras --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">
                        🏫 Data Sarpras
                    </h5>
                    <p class="text-muted">
                        Kelola sarana & prasarana
                    </p>
                    <a href="{{ route('admin.sarpras.index') }}"
                       class="btn btn-success btn-sm">
                        Buka Menu
                    </a>
                </div>
            </div>
        </div>

        {{-- Peminjaman --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning">
                        📦 Peminjaman
                    </h5>
                    <p class="text-muted">
                        Kelola data peminjaman
                    </p>
                    <a href="{{ route('admin.peminjaman.index') }}"
                       class="btn btn-warning btn-sm">
                        Buka Menu
                    </a>
                </div>
            </div>
        </div>

        {{-- Pengaduan --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger">
                        📝 Pengaduan
                    </h5>
                    <p class="text-muted">
                        Kelola laporan pengaduan
                    </p>
                    <a href="{{ route('admin.pengaduan.index') }}"
                       class="btn btn-danger btn-sm">
                        Buka Menu
                    </a>
                </div>
            </div>
        </div>

        {{-- Laporan --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-info">
                        📊 Laporan
                    </h5>
                    <p class="text-muted">
                        Cetak laporan data
                    </p>
                    <a href="{{ route('admin.laporan.asset_health') }}"
                       class="btn btn-info btn-sm">
                        Buka Menu
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
