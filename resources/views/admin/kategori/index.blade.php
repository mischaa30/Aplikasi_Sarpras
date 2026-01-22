<h2>Data Kategori</h2>

<a href="{{ route('admin.kategori.create') }}">Tambah Kategori</a>

<table border="1" cellpadding="5">
<tr>
    <th>Nama Kategori</th>
    <th>Parent</th>
    <th>Aksi</th>
</tr>

@foreach($kategori as $parent)
<tr>
    <td><b>{{ $parent->nama_kategori }}</b></td>
    <td>Root</td>
    <td>
        <a href="{{ route('admin.kategori.edit', $parent->id) }}">Edit</a> |

        <form method="POST"
              action="{{ route('admin.kategori.destroy', $parent->id) }}"
              style="display:inline">
            @csrf
            @method('DELETE')
            <button>Hapus</button>
        </form>
    </td>
</tr>

@foreach($parent->children as $child)
<tr>
    <td>— {{ $child->nama_kategori }}</td>
    <td>{{ $parent->nama_kategori }}</td>
    <td>
        <a href="{{ route('admin.kategori.edit', $child->id) }}">Edit</a> |

        <form method="POST"
              action="{{ route('admin.kategori.destroy', $child->id) }}"
              style="display:inline">
            @csrf
            @method('DELETE')
            <button>Hapus</button>
        </form>
    </td>
</tr>
@endforeach

@endforeach
</table>
