<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

    {{-- BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="container mt-3">

    <h1>Admin Panel</h1>

    <nav class="mb-3">
        <a href="/admin/dashboard">Dashboard</a> |

        <a href="{{ route('admin.user.index') }}">User</a> |
        <a href="{{ route('admin.kategori.index') }}">Kategori Sarpras</a> |
        <a href="{{ route('admin.sarpras.index') }}">Sarpras</a> |
        <a href="{{ route('admin.peminjaman.index') }}">Peminjaman</a> |
        <a href="{{ route('admin.pengaduan.index') }}">Pengaduan</a> |

        <strong>Laporan:</strong>
        <a href="{{ route('admin.laporan.asset_health') }}">Asset Health</a> |

        <strong>Activity Log:</strong>
        <a href="/admin/activity-log/peminjaman">Peminjaman</a> |
        <a href="/admin/activity-log/pengaduan">Pengaduan</a> |

        <a href="{{ route('profil.edit') }}">Profil</a> |
        <a href="/logout">Logout</a>
    </nav>

    <hr>

    <main>
        @yield('content')
    </main>

</body>
</html>
