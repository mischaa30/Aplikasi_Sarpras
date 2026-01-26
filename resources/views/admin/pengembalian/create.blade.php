<h2>Pengembalian - {{ $peminjaman->kode_peminjaman }}</h2>

<form action="{{ route('admin.pengembalian.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

    <div>
        <h4>{{ $peminjaman->sarpras->nama_item }}</h4>

        <input type="hidden" name="detail_id[]" value="{{ $peminjaman->id }}">

        <select name="kondisi_sarpras_id[]">
            @foreach($listKondisi as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kondisi }}</option>
            @endforeach
        </select>

        <input type="text" name="deskripsi[]" placeholder="Deskripsi (opsional)">
        <input type="file" name="foto[]">
    </div>

    <button type="submit">Simpan</button>
</form>
