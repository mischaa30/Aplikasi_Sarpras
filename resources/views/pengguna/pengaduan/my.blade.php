<h2>Riwayat Pengaduan</h2>

<a href="{{ route('pengguna.pengaduan.create') }}">+ Buat Pengaduan</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0" width="50%">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Foto</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $p)
            <tr>
                <td>{{ $p->judul }}</td>
                <td>{{ $p->deskripsi }}</td>
                <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $p->lokasi->nama_lokasi ?? '-' }}</td>
                <td>
                    {{ $p->status->nama_status_pengaduan ?? '-' }}</>
                </td>
                <td align="center">
                    @if($p->foto)
                        <img src="{{ asset('storage/' . $p->foto) }}" width="80">
                    @else
                        -
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" align="center">Belum ada pengaduan</td>
            </tr>
        @endforelse
    </tbody>
</table>
