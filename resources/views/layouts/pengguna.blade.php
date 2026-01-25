<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Pengguna</title>
</head>

<body>
    <h1>Pengguna</h1>
    <nav>
        <a href="/pengguna/dashboard">Dashboard</a> |
        <a href="{{ route('pengguna.kategori.index') }}">Kategori</a> |
        <a href="{{ route('pengguna.peminjaman.index') }}">Peminjaman Saya</a> |
        <a href="{{ route('profil.edit') }}">Profil</a> |
        <a href="/logout">Logout</a>
    </nav>

    <hr>

    @yield('content')
</body>

</html>