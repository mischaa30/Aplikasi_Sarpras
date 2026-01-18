@extends('layouts.admin')

@section('content')
<h3>Kategori Sarpras</h3>

<a href="{{ route('admin.kategori.create') }}">Tambah</a>

<table border="1">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Aksi</th>
    </tr>

    @foreach ( $kategori as $k )
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $k->nama_kategori }}</td>
        <td>
            <a href="{{ route('admin.kategori.edit',$k->id) }}">Edit</a>
            <form action="{{ route('admin.kategori.destroy',$k->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button>hapus</button>
            </form>
        </td>
    </tr>
    
    @endforeach
</table>

@endsection