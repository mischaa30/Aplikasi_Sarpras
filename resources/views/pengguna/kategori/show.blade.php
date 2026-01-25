<h2>Kategori: {{ $kategori->nama_kategori }}</h2>

@if($subKategori->count())
    <h3>Sub Kategori</h3>
    <ul>
        @foreach($subKategori as $s)
            <li>
                <a href="{{ route('pengguna.kategori.show', $s->id) }}">
                    {{ $s->nama_kategori }}
                </a>
            </li>
        @endforeach
    </ul>
@endif

<hr>

@if($sarpras->count())
<hr>
<h3>Daftar Sarpras</h3>

<table border="1" cellpadding="10">
<tr>
    <th>No</th>
    <th>Nama Sarpras</th>
    <th>Aksi</th>
</tr>

@foreach($sarpras as $s)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $s->nama_sarpras }}</td>
    <td>
        <a href="{{ route('pengguna.sarpras.show', $s->id) }}">
            Lihat
        </a>
    </td>
</tr>
@endforeach
</table>
@endif
