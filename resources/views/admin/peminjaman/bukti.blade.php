<h2 style="text-align:center">STRUK PEMINJAMAN</h2>

<div style="width: 350px; border: 1px solid #000; padding: 10px; font-family: Arial;">
    <div style="text-align:center; font-weight:bold;">
        CETAK BUKTI PEMINJAMAN SARPRAS<br>
        SMKN 1 BOYOLANGU
    </div>

    <hr>

    <table width="100%" cellpadding="4">
        <tr>
            <th align="left">Peminjam</th>
            <td>{{ $peminjaman->user->username }}</td>
        </tr>
        <tr>
            <th align="left">Item</th>
            <td>{{ $peminjaman->item?->nama_item ?? '-' }}</td>
        </tr>
        <tr>
            <th align="left">Pinjam</th>
            <td>{{ $peminjaman->tgl_pinjam }}</td>
        </tr>
        <tr>
            <th align="left">Tujuan</th>
            <td>{{ $peminjaman->tujuan }}</td>
        </tr>
        <tr>
            <th align="left">Status</th>
            <td>{{ $peminjaman->status }}</td>
        </tr>
    </table>

    <hr>

    <div style="text-align:center;">
        {!! QrCode::size(120)->generate(json_encode($qrData)) !!}
        <div style="font-size: 10px;">Scan untuk verifikasi</div>
    </div>
</div>
