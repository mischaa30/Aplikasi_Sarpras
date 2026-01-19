<form method="POST" action="{{ route('admin.sarpras.store') }}">
@csrf

Kode:
<input name="kode_sarpras"><br>

Nama:
<input name="nama_sarpras"><br>

Lokasi:
<select name="id_lokasi">
@foreach($lokasi as $l)
<option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
@endforeach
</select><br>

Kategori:
<select name="kategori_id">
@foreach($kategori as $k)
<option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
@endforeach
</select><br>

<button>Simpan</button>
</form>
