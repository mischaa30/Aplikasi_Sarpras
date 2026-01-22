<h2>Edit Profil</h2>

<form method="POST" action="{{ route('profil.update') }}">
    @csrf

    <label>Username</label><br>
    <input type="text" name="username" value="{{ $user->username }}"><br><br>

    <label>Password Baru</label><br>
    <input type="password" name="password">
    <small>Kosongkan jika tidak diganti</small><br><br>

    <button type="submit">Simpan</button>
</form>
