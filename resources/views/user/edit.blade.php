<form method="POST" action="/user/{{ $user->id }}">
@csrf @method('PUT')
<input name="nama" value="{{ $user->nama }}">
<button>Update</button>
</form>
