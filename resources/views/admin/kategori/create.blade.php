@extends('layouts.admin')

@section('content')
<h3>Tambah Kategori</h3>

<form method="POST" action="{{ route('admin.kategori.store') }}">
    @csrf
    <input type="text" name="nama_kategori" placeholder="Nama Kategori">
    <button>Simpan</button>
</form>
@endsection