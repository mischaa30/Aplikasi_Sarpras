@php
$role = strtolower(auth()->user()->role->nama_role ?? '');
@endphp

@extends(
    $role === 'admin' ? 'layouts.admin' :
    ($role === 'petugas' ? 'layouts.petugas' : 'layouts.pengguna')
)

@section('title', 'Edit Profil')

@section('content')

<h4 class="mb-4 fw-semibold">Edit Profil</h4>

<div class="row justify-content-center">

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">

                <form method="POST" action="{{ route('profil.update') }}">
                    @csrf

                    {{-- USERNAME --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>

                        <input type="text"
                               name="username"
                               class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username', $user->username) }}"
                               required>

                        @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    {{-- PASSWORD LAMA --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Lama</label>

                        <div class="input-group">
                            <input type="password"
                                   id="password_lama"
                                   name="password_lama"
                                   class="form-control @error('password_lama') is-invalid @enderror"
                                   value="{{ old('password_lama') }}">

                            <span class="input-group-text toggle-pass" data-target="password_lama">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>

                        @error('password_lama')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD BARU --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>

                        <div class="input-group">
                            <input type="password"
                                   id="password_baru"
                                   name="password_baru"
                                   class="form-control @error('password_baru') is-invalid @enderror"
                                   value="{{ old('password_baru') }}">

                            <span class="input-group-text toggle-pass" data-target="password_baru">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>

                        @error('password_baru')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti password
                        </small>
                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Konfirmasi Password Baru
                        </label>

                        <div class="input-group">
                            <input type="password"
                                   id="password_konfirmasi"
                                   name="password_baru_confirmation"
                                   class="form-control"
                                   value="{{ old('password_baru_confirmation') }}">

                            <span class="input-group-text toggle-pass" data-target="password_konfirmasi">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary px-4">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>


{{-- SCRIPT TOGGLE PASSWORD --}}
<script>
document.querySelectorAll('.toggle-pass').forEach(function(btn) {
    btn.addEventListener('click', function() {

        const target = document.getElementById(this.dataset.target);
        const icon = this.querySelector('i');

        if (target.type === "password") {
            target.type = "text";
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            target.type = "password";
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }

    });
});
</script>

@endsection
