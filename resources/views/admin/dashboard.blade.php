@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container">

    {{-- Welcome --}}
    <div class="mb-4">
        <h3 class="fw-semibold text-primary">
            Selamat Datang di Aplikasi Sarpras SMKN 1 BOYOLANGU
        </h3>
        <p class="text-muted mb-0">
            Halo, {{ auth()->user()->username ?? 'Admin' }} 👋
        </p>
    </div>

    {{-- Cards --}}
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total User</h6>
                    <h2 class="fw-bold text-primary">{{ $totalUser ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Sarpras</h6>
                    <h2 class="fw-bold text-success">{{ $totalSarpras ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Laporan Peminjaman</h6>
                    <h2 class="fw-bold text-warning">{{ $totalPeminjaman ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
