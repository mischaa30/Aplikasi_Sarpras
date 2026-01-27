<h2>Data Peminjaman</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Peminjam</th>
        <th>Sarpras</th>
        <th>Tgl Pinjam</th>
        <th>Tujuan</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($peminjaman as $p)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $p->user->username }}</td>
        <td>{{ $p->item?->nama_item ?? '-' }}</td>
        <td>{{ $p->tgl_pinjam }}</td>
        <td>{{ $p->tujuan }}</td>
        <td>{{ $p->status }}</td>
        <td>

            {{-- MENUNGGU --}}
            @if($p->status === 'Menunggu')
                <form method="POST" action="/admin/peminjaman/{{ $p->id }}/setujui">
                    @csrf
                    <button>Setujui</button>
                </form>

                <form method="POST" action="/admin/peminjaman/{{ $p->id }}/tolak">
                    @csrf
                    <input type="text" name="alasan" placeholder="Alasan penolakan">
                    <button>Tolak</button>
                </form>

            {{-- DISETUJUI --}}
            @elseif($p->status === 'Disetujui')
                <a href="{{ route('admin.peminjaman.bukti', $p->id) }}">
                    Cetak Bukti
                </a>
                |
                <a href="{{ route('admin.pengembalian.create', $p->id) }}">
                    Pengembalian
                </a>

            {{-- DITOLAK --}}
            @else
                -
            @endif

        </td>
    </tr>
    @endforeach
</table>
