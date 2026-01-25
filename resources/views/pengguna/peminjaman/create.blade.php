<h2>Form Peminjaman</h2>

<p>
<b>Barang:</b> {{ $item->sarpras->nama_sarpras }} <br>
<b>Item:</b> {{ $item->nama_item }}
</p>

<form method="POST" action="{{ route('pengguna.peminjaman.store', $item->id) }}">
@csrf

<label>Tanggal Pinjam</label><br>
<input type="date" name="tgl_pinjam" value="{{ date('Y-m-d') }}" readonly><br><br>

<label>Tanggal Pengembalian</label><br>
<input type="date" name="tgl_kembali" required><br><br>

<label>Tujuan</label><br>
<input type="text" name="tujuan" required><br><br>

<button type="submit">Ajukan Peminjaman</button>
</form>
