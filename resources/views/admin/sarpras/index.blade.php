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

        {{-- KATEGORI AMAN (TIDAK ERROR) --}}
        <td>
            @if($s->kategori && $s->kategori->parent)
            {{ $s->kategori->parent->nama_kategori }}
            -
            {{ $s->kategori->nama_kategori }}
            @elseif($s->kategori)
            {{ $s->kategori->nama_kategori }}
            @else
            -
            @endif
        </td>

        <td>{{ $s->items->count() }}</td>

        <td>
            <a href="{{ route('admin.sarpras.show', $s->id) }}">Detail</a> |
            <a href="{{ route('admin.sarpras.edit', $s->id) }}">Edit</a> |
            <a href="{{ route('admin.sarpras.item.create', $s->id) }}">Tambah Data</a> |

            <form action="{{ route('admin.sarpras.destroy', $s->id) }}"
                method="POST"
                style="display:inline"
                onsubmit="return confirm('Yakin hapus sarpras ini?')">

                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>

    </tr>
    @endforeach
</table>