<h2>Dashboard Admin</h2>

<p>Selamat datang {{ Auth::user()->username }}</p>

<h3>Data User</h3>

<a href="{{ route('admin.user.create') }}">Tambah User</a>

<table border="1" cellpadding="5">
    <tr>
        <th>Username</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>

    @foreach($user as $u)
    <tr>
        <td>{{ $u->username }}</td>
        <td>{{ $u->role->nama_role }}</td>
        <td>
            <a href="{{ route('admin.user.edit', $u->id) }}">Edit</a>

            <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Yakin hapus user?')">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
