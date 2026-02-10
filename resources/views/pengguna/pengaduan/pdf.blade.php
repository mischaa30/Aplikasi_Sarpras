<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Pengaduan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h3 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background-color: #f2f2f2; }
        .badge { padding: 2px 5px; border-radius: 4px; font-size: 10px; color: #fff; background-color: #6c757d; }
    </style>
</head>
<body>

    <h3>RIMAYAT PENGADUAN SAYA</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Diproses Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td style="text-align:center">{{ $loop->iteration }}</td>
                <td>{{ $d->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $d->judul }}</td>
                <td>{{ $d->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $d->lokasi->nama_lokasi ?? '-' }}</td>
                <td style="text-align:center">
                    {{ $d->status->nama_status_pengaduan ?? '-' }}
                </td>
                <td>{{ $d->diprosesOleh->username ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
