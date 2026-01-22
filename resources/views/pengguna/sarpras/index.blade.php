<h2>Daftar Sarpras Yang Bisa Dipinjam</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Nama Sarpras</th>
        <th>Stok</th>
        <th>Jumlah</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Kembali</th>
        <th>Tujuan</th>
        <th>Aksi</th>
    </tr>

    @foreach($sarpras as $s)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $s->nama_sarpras }}</td>
        <td>{{ $s->stok }}</td>

        <td colspan="5">
            <form method="POST" action="/pengguna/pinjam">
                @csrf
                <input type="hidden" name="sarpras_id" value="{{ $s->id }}">

                <input type="number" name="jumlah"
                       min="1" max="{{ $s->stok }}" required>

                <input type="date" name="tgl_pinjam" required>

                <input type="date" name="tgl_kembali" required>

                <input type="text" name="tujuan"
                       placeholder="Tujuan peminjaman">

        </td>
        <td>
                <button type="submit">Ajukan</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
