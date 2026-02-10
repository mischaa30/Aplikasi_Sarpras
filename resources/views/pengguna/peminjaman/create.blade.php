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
                            id="tgl_pinjam"
                            min="{{ date('Y-m-d') }}"
                            class="form-control"
                            required>
                        <div class="form-text text-danger" id="tglPinjamError" style="display:none"></div>
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

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const tglPinjam = document.getElementById('tgl_pinjam');
                    const tglPinjamError = document.getElementById('tglPinjamError');
                    if (tglPinjam) {
                        tglPinjam.value = new Date().toISOString().slice(0, 10);
                        tglPinjam.addEventListener('change', function() {
                            const val = this.value;
                            const date = new Date(val);
                            const day = date.getDay();
                            if (day === 0 || day === 6) {
                                tglPinjamError.style.display = '';
                                tglPinjamError.textContent = 'Tanggal pinjam tidak boleh hari Sabtu atau Minggu.';
                                this.value = '';
                            } else {
                                tglPinjamError.style.display = 'none';
                            }
                        });
                    }
                    // Prevent submit if tglPinjam is weekend
                    const form = tglPinjam?.form;
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            const val = tglPinjam.value;
                            const date = new Date(val);
                            const day = date.getDay();
                            if (day === 0 || day === 6) {
                                tglPinjamError.style.display = '';
                                tglPinjamError.textContent = 'Tanggal pinjam tidak boleh hari Sabtu atau Minggu.';
                                e.preventDefault();
                            }
                        });
                    }
                });
            </script>

        </div>
    </div>

</div>
@endsection