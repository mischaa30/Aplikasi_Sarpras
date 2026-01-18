<form action="{{ route('admin.user.store') }}" method="POST">
@csrf

<input name="username" placeholder="Username">
<input name="password" placeholder="Password">

<select name="id_role">
@foreach($role as $r) //dropdown user
<option value="{{ $r->id }}">{{ $r->nama_role }}</option>
@endforeach
</select>

<button>Simpan</button>
</form>
