<h2>Activity Log Peminjaman</h2>

<form method="GET">
    Dari <input type="date" name="from" value="{{ request('from') }}">
    Sampai <input type="date" name="to" value="{{ request('to') }}">
    <button>Filter</button>
</form>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Peminjam</th>
        <th>Sarpras</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Kembali</th>
        <th>Tujuan</th>
    </tr>

    @foreach($data as $p)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $p->user->username }}</td>
        <td>{{ $p->item?->nama_item }}</td>
        <td>{{ $p->tgl_pinjam }}</td>
        <td>{{ $p->tgl_kembali_actual }}</td>
        <td>{{ $p->tujuan }}</td>
    </tr>
    @endforeach
</table>
