@extends('layouts.admin')

@section('content')
<h3>Edit Kategori</h3>

<form method="POST"action="{{ route('admin.kategori.update',$kategori->id) }}">
    @csrf
    @method('PUT')
    <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}">
    <button>Update</button>
</form>

@endsection