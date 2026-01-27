<h2>Activity Log Pengaduan</h2>

<form method="GET">
    Dari <input type="date" name="from" value="{{ request('from') }}">
    Sampai <input type="date" name="to" value="{{ request('to') }}">
    <button>Filter</button>
</form>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>User</th>
        <th>Judul</th>
        <th>Status</th>
        <th>Tanggal</th>
    </tr>

    @foreach($data as $d)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->user->username }}</td>
        <td>{{ $d->judul }}</td>
        <td>{{ $d->status->nama_status_pengaduan }}</td>
        <td>{{ $d->created_at }}</td>
    </tr>
    @endforeach
</table>
