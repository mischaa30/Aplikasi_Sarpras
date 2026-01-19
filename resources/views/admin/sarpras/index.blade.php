<h2>Data Sarpras</h2>

<a href="{{ route('admin.sarpras.create') }}">Tambah Sarpras</a>

<table border="1" cellpadding="5">
    <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Lokasi</th>
        <th>Kategori</th>
        <th>Kondisi</th>
        <th>Stok</th>
        <th>Aksi</th>
        <th>Tambah Stok</th>
    </tr>

    @foreach($sarpras as $s)
    <tr>
        <td>{{ $s->kode_sarpras }}</td>
        <td>{{ $s->nama_sarpras }}</td>
        <td>{{ $s->lokasi->nama_lokasi }}</td>
        <td>{{ $s->kategori->nama_kategori }}</td>

        <td>
            @foreach($s->kondisiDetail as $k)
            {{ $k->kondisi->kondisi_sarpras }} ({{ $k->jumlah }})<br>
            @endforeach
        </td>

        <td>
            {{ $s->kondisiDetail->sum('jumlah') }}
        </td>

        <td>
            <a href="{{ route('admin.sarpras.edit',$s->id) }}">Edit</a>
            <form action="{{ route('admin.sarpras.destroy',$s->id) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button onclick="return confirm('Hapus data?')">Hapus</button>
            </form>
        </td>
        <td>
            <a href="{{ route('admin.sarpras.kondisi.create', $s->id) }}">Tambah Stok</a>
        </td>
    </tr>
    @endforeach
</table>

{{ $sarpras->links() }}