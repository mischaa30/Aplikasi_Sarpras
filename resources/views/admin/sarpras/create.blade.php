<h2>Tambah Sarpras</h2>

<form method="POST" action="{{ route('admin.sarpras.store') }}">
@csrf

Kode:
<input name="kode_sarpras" required><br><br>

Nama:
<input name="nama_sarpras" required><br><br>

Lokasi:
<select name="id_lokasi">
@foreach($lokasi as $l)
    <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
@endforeach
</select><br><br>

Kategori:
<select name="kategori_id">
@foreach($kategori as $k)
    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
@endforeach
</select><br><br>

<button>Simpan</button>
</form>
