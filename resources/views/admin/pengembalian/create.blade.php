<form method="POST" action="{{ route('admin.pengembalian.store') }}" enctype="multipart/form-data">
@csrf

<input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

<label>Tanggal Kembali</label>
<input type="date" name="tgl_kembali_actual" required>

<hr>

@foreach($peminjaman->detail as $i => $d)
    <h4>{{ $d->sarprasItem->nama_item }}</h4>

    <input type="hidden" name="detail_id[]" value="{{ $d->id }}">

    <select name="kondisi_sarpras_id[]" required>
        @foreach($listKondisi as $k)
            <option value="{{ $k->id }}">{{ $k->nama_kondisi }}</option>
        @endforeach
    </select>

    <textarea name="deskripsi[]" placeholder="Keterangan (opsional)"></textarea>

    <input type="file" name="foto[]">

    <hr>
@endforeach

<button type="submit">Simpan Pengembalian</button>
</form>
