<h2>Data Sarpras</h2>

<a href="{{ route('admin.sarpras.create') }}">Tambah Sarpras</a>

<table border="1" cellpadding="5">
<tr>
    <th>Kode</th>
    <th>Nama</th>
    <th>Lokasi</th>
    <th>Kategori</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>

@foreach($sarpras as $s)
<tr>
    <td>{{ $s->kode_sarpras }}</td>
    <td>{{ $s->nama_sarpras }}</td>
    <td>{{ $s->lokasi->nama_lokasi }}</td>
    <td>{{ $s->kategori->nama_kategori }}</td>
    <td>{{ $s->items->count() }}</td>
    <td>
        <a href="{{ route('admin.sarpras.show', $s->id) }}">Detail</a>
        |
        <a href="{{ route('admin.sarpras.edit', $s->id) }}">Edit</a>
    </td>
</tr>
@endforeach
</table>
