<h2>Detail Sarpras</h2>

<p>
<b>Nama:</b> {{ $sarpras->nama_sarpras }} <br>
<b>Lokasi:</b> {{ $sarpras->lokasi->nama_lokasi }} <br>
<b>Kategori:</b> {{ $sarpras->kategori->nama_kategori }}
</p>

<h3>Daftar Unit Barang</h3>

<table border="1" cellpadding="5">
<tr>
    <th>Nama Unit</th>
    <th>Kondisi</th>
    <th>Aksi</th>
</tr>

@foreach($sarpras->items as $item)
<tr>
    <td>{{ $item->nama_item }}</td>
    <td>{{ $item->kondisi->nama_kondisi }}</td>
    <td>
        <a href="{{ route('admin.sarpras.item.edit', $item->id) }}">Edit</a>

        <form method="POST"
              action="{{ route('admin.sarpras.item.destroy', $item->id) }}"
              style="display:inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Hapus unit ini?')">
                Hapus
            </button>
        </form>
    </td>
</tr>
@endforeach
</table>
