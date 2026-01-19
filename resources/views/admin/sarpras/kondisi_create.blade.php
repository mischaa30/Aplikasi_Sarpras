<h2>Tambah Stok - {{ $sarpras->nama_sarpras }}</h2>

<form method="POST" action="{{ route('admin.sarpras.kondisi.store', $sarpras->id) }}">
    @csrf

    <label>Kondisi</label>
    <select name="kondisi_sarpras_id">
        @foreach($listKondisi as $k)
            <option value="{{ $k->id }}">{{ $k->kondisi_sarpras }}</option>
        @endforeach
    </select>
    <br><br>

    <label>Jumlah</label>
    <input type="number" name="jumlah" min="1" required>
    <br><br>

    <button type="submit">Tambah Stok</button>
</form>
