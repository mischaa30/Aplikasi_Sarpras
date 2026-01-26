<h2>Daftar Pengaduan</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Pelapor</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->judul }}</td>
            <td>{{ $p->user->username }}</td>
            <td>{{ $p->kategori->nama_kategori }}</td>
            <td>{{ $p->lokasi->nama_lokasi }}</td>
            <td>{{ $p->status->nama_status_pengaduan }}</td>
            <td>{{ $p->created_at->format('d-m-Y') }}</td>
            <td>
                <a href="{{ route('admin.pengaduan.show', $p->id) }}">
                    Detail
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">Belum ada pengaduan</td>
        </tr>
        @endforelse
    </tbody>
</table>
