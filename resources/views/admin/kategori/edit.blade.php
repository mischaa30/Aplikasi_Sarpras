<h3>Edit Kategori</h3>

<form method="POST" action="{{ route('admin.kategori.update', $kategori->id) }}">
    @csrf
    @method('PUT')

    Nama Kategori:
    <input name="nama_kategori" value="{{ $kategori->nama_kategori }}" required>

    Parent:
    <select name="parent_id">
        <option value="">-- Root --</option>

        @foreach($parent as $p)
            <option value="{{ $p->id }}" {{ $kategori->parent_id == $p->id ? 'selected' : '' }}>
                {{ $p->nama_kategori }}
            </option>
        @endforeach
    </select>

    <button>Update</button>
</form>
