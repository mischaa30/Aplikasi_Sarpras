<h2>Edit Sarpras</h2>

<form method="POST" action="{{ route('admin.sarpras.update',$sarpras->id) }}">
@csrf @method('PUT')

Kode:
<input type="text" name="kode_sarpras" value="{{ $sarpras->kode_sarpras }}"><br>

Nama:
<input type="text" name="nama_sarpras" value="{{ $sarpras->nama_sarpras }}"><br>

Lokasi:
<select name="id_lokasi">
@foreach($lokasi as $l)
<option value="{{ $l->id }}" @selected($sarpras->id_lokasi==$l->id)>
    {{ $l->nama_lokasi }}
</option>
@endforeach
</select><br>

Kategori:
<select name="kategori_id">
@foreach($kategori as $k)
<option value="{{ $k->id }}" @selected($sarpras->kategori_id==$k->id)>
    {{ $k->nama_kategori }}
</option>
@endforeach
</select><br>

Kondisi:
<select name="id_kondisi_sarpras">
@foreach($kondisi as $k)
<option value="{{ $k->id }}" @selected($sarpras->id_kondisi_sarpras==$k->id)>
    {{ $k->nama_kondisi }}
</option>
@endforeach
</select><br>

Jumlah:
<input type="number" name="jumlah_stok" value="{{ $sarpras->jumlah_stok }}"><br>

<button>Update</button>
</form>
