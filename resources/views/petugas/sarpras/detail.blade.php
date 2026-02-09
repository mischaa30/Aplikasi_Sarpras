@extends('layouts.petugas')

@section('content')

<a href="{{ route('petugas.sarpras.index') }}"
   class="btn btn-secondary btn-sm mb-3">
    ← Kembali
</a>

<h4 class="mb-3 text-primary">
Detail Item — {{ $sarpras->nama_sarpras }}
</h4>

<div class="card shadow-sm">
<div class="card-body">

<table class="table table-bordered">
<thead class="table-light">
<tr>
    <th>No</th>
    <th>Nama Item</th>
    <th>Kondisi</th>
</tr>
</thead>

<tbody>
@foreach($sarpras->items as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->nama_item }}</td>
    <td>{{ $item->kondisi->nama_kondisi ?? '-' }}</td>
</tr>
@endforeach
</tbody>

</table>

</div>
</div>

@endsection
