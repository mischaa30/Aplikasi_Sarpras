@extends('layouts.pengguna')

@section('content')
<div class="container-fluid mt-3">

    <h3 class="mb-4 text-primary fw-semibold">
        📝 Buat Pengaduan
    </h3>

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">

                <div class="card-header bg-primary text-white">
                    Form Pengaduan
                </div>

                <div class="card-body">

                    <form action="{{ route('pengguna.pengaduan.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Judul Pengaduan</label>
                            <input type="text"
                                   name="judul"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi"
                                      class="form-control"
                                      rows="4"
                                      required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <select name="lokasi_id"
                                    class="form-select"
                                    required>
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach($lokasi as $l)
                                    <option value="{{ $l->id }}">
                                        {{ $l->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Sarpras</label>
                            <select name="kategori_sarpras_id"
                                    class="form-select"
                                    required>
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto (Opsional)</label>
                            <input type="file"
                                   name="foto"
                                   class="form-control">
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Kirim Pengaduan
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
