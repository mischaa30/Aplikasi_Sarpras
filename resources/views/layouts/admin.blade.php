<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f0f4ff;
            margin: 0;
        }

        /* Topbar tetap di atas tapi main content scrollable */
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


        /* Sidebar kiri */
        .sidebar {
            width: 220px;
            background-color: #1e3a8a;
            color: #ffffff;
            position: fixed;
            top: 60px;
            /* di bawah topbar */
            left: 0;
            bottom: 0;
            padding-top: 20px;
            overflow-y: auto;
        }

        .sidebar a {
            color: #cfd6fc;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            margin-bottom: 4px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: #3b82f6;
            color: #fff;
        }

        /* Main content */
        main {
            margin-left: 220px;
            /* space untuk sidebar */
            padding: 20px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .card h5 {
            color: #1e3a8a;
        }

        /* Print styles */
        @media print {
            .topbar, .sidebar, .no-print { display: none !important; }
            body { background: #fff !important; }
            main { margin-left: 0 !important; padding: 10px !important; }
            .card { box-shadow: none !important; border: none !important; }
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
    <div class="sidebar d-flex flex-column p-3">
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-primary text-white' : '' }}">
            Dashboard
        </a>

        <span class="text-white fw-bold mt-3 mb-2">Master Data</span>

        <a href="{{ route('admin.user.index') }}"
            class="{{ request()->routeIs('admin.user.*') ? 'active bg-primary text-white' : '' }}">
            User
        </a>

        <a href="{{ route('admin.kategori.index') }}"
            class="{{ request()->routeIs('admin.kategori.*') ? 'active bg-primary text-white' : '' }}">
            Kategori Sarpras
        </a>

        <a href="{{ route('admin.lokasi.index') }}"
            class="{{ request()->routeIs('admin.lokasi.*') ? 'active bg-primary text-white' : '' }}">
            Lokasi
        </a>

        <a href="{{ route('admin.sarpras.index') }}"
            class="{{ request()->routeIs('admin.sarpras.*') ? 'active bg-primary text-white' : '' }}">
            Sarpras
        </a>

        <hr class="text-gray-400">

        <a href="{{ route('admin.peminjaman.index') }}"
            class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active bg-primary text-white' : '' }}">
            Peminjaman
        </a>

        <a href="{{ route('admin.pengaduan.index') }}"
            class="nav-link {{ request()->routeIs('admin.pengaduan.*') ? 'active bg-primary text-white' : '' }}">
            Pengaduan
        </a>

        <hr class="text-gray-400">

        <span class="text-white fw-bold mb-2">Laporan</span>
        <a href="{{ route('admin.laporan.asset_health') }}">Asset Health</a>

        <hr class="text-gray-400">

        <span class="text-white fw-bold mt-3 mb-2">Activity Log</span>

        <a href="{{ route('admin.activity.login') }}"
            class="{{ request()->routeIs('admin.activity.login') ? 'active bg-primary text-white' : '' }}">
            Login
        </a>

        <a href="/admin/activity-log/peminjaman"
            class="{{ request()->is('admin/activity-log/peminjaman') ? 'active bg-primary text-white' : '' }}">
            Peminjaman
        </a>

        <a href="/admin/activity-log/pengaduan"
            class="{{ request()->is('admin/activity-log/pengaduan') ? 'active bg-primary text-white' : '' }}">
            Pengaduan
        </a>

        <hr class="text-gray-400">
        <a href="{{ route('profil.edit') }}">Profil</a>
    </div>

    <!-- Main Content -->
    <main>
        @include('partials.alerts')
        @yield('content')
    </main>

</body>

</html>