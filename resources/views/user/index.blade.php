<h3>Data User</h3>
<a href="/user/create">Tambah User</a>

@foreach($user as $u)
  {{ $u->nama }} - {{ $u->role->nama_role }}
@endforeach
