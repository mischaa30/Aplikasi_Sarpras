<h2>Daftar Kategori Sarpras</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
    </tr>

@foreach($kategori as $k)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $k->nama_kategori }}</td>
        <td>
            <a href="{{ route('pengguna.kategori.show', $k->id) }}">
                Lihat
            </a>
        </td>
    </tr>
@endforeach
</table>
