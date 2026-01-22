<h3>Tambah Kategori</h3>

<form method="POST" action="{{ route('admin.kategori.store') }}">
    @csrf

    Nama Kategori:
    <input name="nama_kategori" required>

    Parent:
    <select name="parent_id">
        <option value="">-- Root (Kategori Utama) --</option>

        @foreach($kategori as $k)
            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
        @endforeach
    </select>

    <button>Tambah</button>
</form>
