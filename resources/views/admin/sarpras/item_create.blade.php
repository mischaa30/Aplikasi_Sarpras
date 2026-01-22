<h3>Tambah Unit Barang</h3>

<form method="POST" action="{{ route('admin.sarpras.item.store', $sarpras->id) }}">
@csrf

Nama Unit:
<input name="nama_item" placeholder="" required>

Kondisi:
<select name="kondisi_sarpras_id">
@foreach($listKondisi as $k)
    <option value="{{ $k->id }}">{{ $k->nama_kondisi }}</option>
@endforeach

</select>

<button>Tambah</button>
</form>

