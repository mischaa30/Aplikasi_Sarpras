<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Activity Log</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h3 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background: #eee;
        }
    </style>
</head>
<body>

<h3>Activity Log Peminjaman</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Sarpras</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Tujuan</th>
            <th>Disetujui</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->user->username ?? '-' }}</td>
            <td>{{ $p->item?->nama_item ?? '-' }}</td>
            <td>{{ $p->tgl_pinjam }}</td>
            <td>{{ $p->tgl_kembali_actual ?? '-' }}</td>
            <td>{{ $p->tujuan }}</td>
            <td>{{ $p->approver->username ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
