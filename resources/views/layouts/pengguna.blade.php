<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengguna Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
            background-color: #1e3a8a;
            color: #ffffff;
            position: fixed;
            top: 60px;
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
            padding: 20px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .card h5 {
            color: #1e3a8a;
        }

        /* Responsive untuk HP */
        @media (max-width: 768px) {

            .sidebar {
                left: -220px;
                /* sembunyi */
                transition: 0.3s;
            }

            .sidebar.active {
                left: 0;
                /* muncul */
            }

            main {
                margin-left: 0;
                /* full */
            }

            .sidebar-overlay {
                position: fixed;
                top: 60px;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,.25);
                display: none;
            }

            .sidebar.active + .sidebar-overlay {
                display: block;
            }

            body.sidebar-open {
                overflow: hidden;
            }
        }
    </style>
</head>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var btn = document.getElementById('btnToggle');
        if (btn) {
            btn.addEventListener('click', function () {
                var sb = document.querySelector('.sidebar');
                if (sb) {
                    sb.classList.toggle('active');
                    var isActive = sb.classList.contains('active');
                    document.body.classList.toggle('sidebar-open', isActive);
                }
            });
        }
        var ov = document.getElementById('sidebarOverlay');
        if (ov) {
            ov.addEventListener('click', function () {
                if (window.innerWidth <= 768) {
                    var sb = document.querySelector('.sidebar');
                    if (sb) {
                        sb.classList.remove('active');
                        document.body.classList.remove('sidebar-open');
                    }
                }
            });
        }
        var links = document.querySelectorAll('.sidebar a');
        links.forEach(function (a) {
            a.addEventListener('click', function () {
                if (window.innerWidth <= 768) {
                    var sb = document.querySelector('.sidebar');
                    if (sb) {
                        sb.classList.remove('active');
                        document.body.classList.remove('sidebar-open');
                    }
                }
            });
        });
    });
</script>


<body>

    <!-- Topbar -->
    <div class="topbar">

        <!-- KIRI -->
        <div class="d-flex align-items-center gap-2">

            <!-- Tombol menu (HP) -->
            <button class="btn btn-outline-primary d-md-none" id="btnToggle">
                ☰
            </button>

            <span class="fw-bold text-primary fs-5">
                APLIKASI SARPRAS
            </span>
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

        <!-- Dashboard -->
        <a href="{{ route('pengguna.dashboard') }}"
            class="{{ request()->routeIs('pengguna.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>


        <!-- MENU -->
        <span class="text-white fw-bold mt-3 mb-2">Menu</span>
        <a href="{{ route('pengguna.kategori.index') }}"
            class="{{ request()->routeIs('pengguna.kategori.*') ? 'active' : '' }}">
            Peminjaman
        </a>

        <a href="{{ route('pengguna.peminjaman.index') }}"
            class="{{ request()->routeIs('pengguna.peminjaman.*') ? 'active' : '' }}">
            Peminjaman Saya
        </a>

        <a href="{{ route('pengguna.pengaduan.index') }}"
            class="{{ request()->routeIs('pengguna.pengaduan.*') ? 'active' : '' }}">
            Pengaduan
        </a>


        <hr class="text-gray-400">


        <!-- AKUN -->
        <a href="{{ route('profil.edit') }}"
            class="{{ request()->routeIs('profil.*') ? 'active' : '' }}">
            Profil
        </a>

    </div>

    <!-- Main Content -->
    <main>
        
        @yield('content')
    </main>

    <div id="sidebarOverlay" class="sidebar-overlay d-md-none"></div>

</body>

</html>
