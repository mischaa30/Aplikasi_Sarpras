<h2>Tambah Sarpras</h2>

<form method="POST" action="{{ route('admin.sarpras.store') }}">
@csrf

Kode:
<input name="kode_sarpras" required><br><br>

Nama:
<input name="nama_sarpras" required><br><br>

Lokasi:
<select name="id_lokasi" required>
@foreach($lokasi as $l)
    <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
@endforeach
</select><br><br>

Sub Kategori:
<select name="kategori_id" required>
    <option value="">-- Pilih Sub Kategori --</option>

    @foreach ($childKategori as $c)
        <option value="{{ $c->id }}">
            {{ $c->parent->nama_kategori }} - {{ $c->nama_kategori }}
        </option>
    @endforeach
</select>

<button>Simpan</button>
</form>
