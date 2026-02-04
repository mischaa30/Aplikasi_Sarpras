<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f0f4ff;
            margin: 0;
        }

        /* Topbar */
        .topbar {
            height: 60px;
            width: 100%;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* penting */
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #1e3a8a;
            color: #fff;
            position: fixed;
            top: 60px;
            left: 0;
            bottom: 0;
            padding: 20px 10px;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #cfd6fc;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #3b82f6;
            color: #fff;
        }

        main {
            margin-left: 220px;
            padding: 20px;
        }

        .menu-title {
            font-size: 13px;
            font-weight: bold;
            margin: 15px 10px 5px;
            color: #fff;
            opacity: .8;
        }

        /* Print styles */
        @media print {

            .topbar,
            .sidebar,
            .no-print {
                display: none !important;
            }

            body {
                background: #fff !important;
            }

            main {
                margin-left: 0 !important;
                padding: 10px !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- Topbar -->
    <div class="topbar">

        <!-- KIRI -->
        <div class="fw-bold text-primary fs-5">
            APLIKASI SARPRAS
        </div>

        <!-- KANAN -->
        <div>
            <span class="me-3">
                Halo, {{ auth()->user()->username ?? 'Admin' }}
            </span>

            <a href="/logout" class="btn btn-outline-primary btn-sm">
                Logout
            </a>
        </div>

    </div>


    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Dashboard -->
        <a href="{{ route('petugas.dashboard') }}"
            class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <hr class="text-gray-400">
        <!-- Sarpras -->
        <span class="text-white fw-bold mt-3 mb-2">Sarpras</span>

        <a href="{{ route('petugas.sarpras.index') }}">
            Data Sarpras
        </a>

        <hr class="text-gray-400">
        <!-- PEMINJAMAN -->
        <span class="text-white fw-bold mt-3 mb-2">Peminjaman</span>

        <a href="{{ route('petugas.peminjaman.index') }}">
            Data Peminjaman
        </a>

        <hr class="text-gray-400">
        <!-- PENGADUAN -->
        <span class="text-white fw-bold mt-3 mb-2">Pengaduan</span>

        <a href="{{ route('petugas.pengaduan.index') }}">
            Data Pengaduan
        </a>

        <hr class="text-gray-400">
        <!-- PROFIL -->
        <span class="text-white fw-bold mt-3 mb-2">Akun</span>

        <a href="{{ route('profil.edit') }}">
            Profil
        </a>

    </div>


    <!-- Content -->
    <main>
        @include('partials.alerts')
        @yield('content')
    </main>

</body>

</html>