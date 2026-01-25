<h2>Pinjaman Saya</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Barang</th>
        <th>Tanggal</th>
        <th>Status</th>
    </tr>

    @forelse($data as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>
                {{ $p->item?->sarpras?->nama_sarpras ?? '-' }}
                -
                {{ $p->item?->nama_item ?? '-' }}
            </td>

            <td>{{ $p->tgl_pinjam }}</td>

            <td>{{ $p->status }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" align="center">Belum ada data peminjaman</td>
        </tr>
    @endforelse
</table>
