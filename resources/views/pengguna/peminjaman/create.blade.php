@extends('layouts.pengguna')

@section('content')
<div class="container-fluid mt-3">

    <h3 class="mb-4 text-primary fw-semibold">
        📦 Form Peminjaman
    </h3>

    <div class="card">

        <div class="card-header bg-primary text-white">
            Informasi Barang
        </div>

        <div class="card-body">

            <div class="mb-3">
                <strong>Barang:</strong> {{ $item->sarpras->nama_sarpras }} <br>
                <strong>Item:</strong> {{ $item->nama_item }}
            </div>

            <form method="POST"
                  action="{{ route('pengguna.peminjaman.store', $item->id) }}">

                @csrf

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date"
                               name="tgl_pinjam"
                               value="{{ date('Y-m-d') }}"
                               readonly
                               class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tujuan</label>
                        <input type="text"
                               name="tujuan"
                               required
                               class="form-control"
                               placeholder="Masukkan tujuan">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit"
                                class="btn btn-primary w-100">
                            Ajukan
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
