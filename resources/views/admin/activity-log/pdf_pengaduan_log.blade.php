<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Activity Log Pengaduan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        h3 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 4px; }
        th { background-color: #f2f2f2; text-align: center; }
    </style>
</head>
<body>

    <h3>ACTIVITY LOG PENGADUAN</h3>

    <div style="margin-bottom: 10px;">
        <small>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</small>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Pelapor</th>
                <th>Judul Pengaduan</th>
                <th width="15%">Status</th>
                <th width="15%">Diproses Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td style="text-align:center">{{ $loop->iteration }}</td>
                <td>{{ $d->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $d->user->username ?? '-' }}</td>
                <td>{{ $d->judul }}</td>
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
