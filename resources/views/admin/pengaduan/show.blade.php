<h2>{{ $pengaduan->judul }}</h2>
<p>{{ $pengaduan->deskripsi }}</p>
<p>Lokasi: {{ $pengaduan->lokasi }}</p>
<p>Kategori: {{ $pengaduan->kategori->nama_kategori }}</p>
<p>Status: {{ $pengaduan->status->nama_status }}</p>

@if($pengaduan->foto)
    <img src="{{ asset('storage/' . $pengaduan->foto) }}" width="300">
@endif

<hr>

<form action="{{ route('admin.pengaduan.status', $pengaduan->id) }}" method="POST">
    @csrf
    <select name="status_pengaduan_id">
        @foreach($status as $s)
            <option value="{{ $s->id }}" {{ $pengaduan->status_pengaduan_id == $s->id ? 'selected' : '' }}>
                {{ $s->nama_status }}
            </option>
        @endforeach
    </select>
    <button type="submit">Update Status</button>
</form>

<hr>

<h3>Tambah Catatan</h3>
<form action="{{ route('admin.pengaduan.catatan', $pengaduan->id) }}" method="POST">
    @csrf
    <textarea name="catatan" placeholder="Tulis catatan..." required></textarea>
    <button type="submit">Tambah</button>
</form>

<hr>

<h3>Catatan</h3>
@foreach($pengaduan->catatan as $c)
    <div>
        <b>{{ $c->user->name }}</b> - {{ $c->created_at }}
        <p>{{ $c->catatan }}</p>
    </div>
@endforeach
