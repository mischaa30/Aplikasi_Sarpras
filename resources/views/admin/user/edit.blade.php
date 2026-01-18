<h3>Edit User</h3>

<form method="POST" action="{{ route('admin.user.update',$user->id) }}">
    @csrf
    @method('PUT')

    <input name="username" value="{{ $user->username }}">

    <select name="id_role">
        @foreach($role as $r)
            <option value="{{ $r->id }}"
                {{ $user->id_role == $r->id ? 'selected' : '' }}>
                {{ $r->nama_role }}
            </option>
        @endforeach
    </select>

    <button>Update</button>
</form>
