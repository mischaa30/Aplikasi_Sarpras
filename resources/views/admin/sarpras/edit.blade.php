<h2>Edit Sarpras</h2>

<form method="POST" action="{{ route('admin.sarpras.update', $sarpras->id) }}">
    @csrf
    @method('PUT')

    Kode:
    <input name="kode_sarpras" value="{{ $sarpras->kode_sarpras }}"><br><br>

    Nama:
    <input name="nama_sarpras" value="{{ $sarpras->nama_sarpras }}"><br><br>

    Lokasi:
    <select name="id_lokasi">
        @foreach($lokasi as $l)
        <option value="{{ $l->id }}"
            {{ $sarpras->id_lokasi == $l->id ? 'selected' : '' }}>
            {{ $l->nama_lokasi }}
        </option>
        @endforeach
    </select><br><br>

    Kategori:
    <select name="kategori_id">
        @foreach ($kategori as $c)
        <option value="{{ $c->id }}"
            {{ $sarpras->kategori_id == $c->id ? 'selected' : '' }}>
            {{ optional($c->parent)->nama_kategori }} - {{ $c->nama_kategori }}
        </option>
        @endforeach
    </select>


    <button>Update</button>
</form>