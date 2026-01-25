<h2>Daftar Item {{ $sarpras->nama_sarpras }}</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Item</th>
        <th>Kondisi</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($sarpras->items as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_item }}</td>

        {{-- KONDISI --}}
        <td>{{ $item->kondisi->nama_kondisi }}</td>

        {{-- STATUS (AMBIL DARI PEMINJAMAN) --}}
        <td>
            @if($item->peminjamanAktif)
                {{ $item->peminjamanAktif->status }}
            @else
                Tersedia
            @endif
        </td>

        {{-- AKSI --}}
        <td>
            @if(
                $item->kondisi->nama_kondisi == 'Baik'
                && !$item->peminjamanAktif
            )
                <a href="{{ route('pengguna.peminjaman.create', $item->id) }}">
                    Pinjam
                </a>
            @else
                -
            @endif
        </td>
    </tr>
    @endforeach
</table>
