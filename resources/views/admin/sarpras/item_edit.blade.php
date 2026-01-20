<h2>Edit Unit Barang</h2>

<form method="POST" action="{{ route('admin.sarpras.item.update', $item->id) }}">
@csrf
@method('PUT')

Nama Unit:
<input name="nama_item" value="{{ $item->nama_item }}" required><br><br>

Kondisi:
<select name="kondisi_sarpras_id">
@foreach($listKondisi as $k)
    <option value="{{ $k->id }}"
        {{ $item->kondisi_sarpras_id == $k->id ? 'selected' : '' }}>
        {{ $k->nama_kondisi }}
    </option>
@endforeach
</select><br><br>

<button>Simpan</button>
</form>
