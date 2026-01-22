<h2>Bukti Peminjaman Sarpras</h2>

<p><b>Kode:</b> {{ $p->kode_pinjam }}</p>
<p><b>Peminjam:</b> {{ $p->user->username }}</p>
<p><b>Sarpras:</b> {{ $p->sarpras->nama_sarpras }}</p>
<p><b>Jumlah:</b> {{ $p->jumlah }}</p>
<p><b>Tanggal:</b> {{ $p->tgl_pinjam }} s/d {{ $p->tgl_kembali }}</p>
<p><b>Tujuan:</b> {{ $p->tujuan }}</p>
<p><b>Status:</b> {{ $p->status }}</p>

{!! QrCode::size(150)->generate($p->kode_pinjam) !!}

<br><br>
<button onclick="window.print()">Cetak</button>
