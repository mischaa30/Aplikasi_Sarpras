<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
</head>

<body>
    <h1>Admin</h1>

    <nav>
        <a href="/admin/dashboard">Dashboard</a> |
        <a href="{{ route('admin.user.index') }}">User</a> |
        <a href="{{ route('admin.kategori.index') }}">Kategori Sarpras</a> |
        <a href="{{ route('admin.sarpras.index') }}">Sarpras</a> |
        <a href="/logout">Logout</a>
    </nav>

    <hr>

    @yield('content')
</body>

</html>