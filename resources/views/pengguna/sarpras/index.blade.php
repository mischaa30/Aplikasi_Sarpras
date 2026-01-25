<h2>Daftar Sarpras</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Jenis Sarpras</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

@foreach($sarpras as $s)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $s->nama_sarpras }}</td>
        <td>{{ $s->stok }}</td>
        <td>
            <a href="{{ route('pengguna.sarpras.show', $s->id) }}">
                Lihat
            </a>
        </td>
    </tr>
@endforeach
</table>
