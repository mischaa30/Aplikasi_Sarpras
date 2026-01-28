<h2>Activity Log Pengaduan</h2>

<form method="GET">
    Status
    <select name="status">
        <option value="">Semua</option>
        @foreach($listStatus as $status)
        <option value="{{ $status->nama_status_pengaduan }}"
            {{ request('status') == $status->nama_status_pengaduan ? 'selected' : '' }}>
            {{ $status->nama_status_pengaduan }}
        </option>
        @endforeach
    </select>
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