<h2>Tambah Sarpras</h2>

<form method="POST" action="{{ route('admin.sarpras.store') }}">
@csrf

Kode:
<input type="text" name="kode_sarpras"><br>

Nama:
<input type="text" name="nama_sarpras"><br>

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

Kondisi:
<select name="id_kondisi_sarpras">
@foreach($kondisi as $k)
<option value="{{ $k->id }}">{{ $k->nama_kondisi }}</option>
@endforeach
</select><br>

Jumlah:
<input type="number" name="jumlah_stok"><br>

<button>Simpan</button>
</form>
