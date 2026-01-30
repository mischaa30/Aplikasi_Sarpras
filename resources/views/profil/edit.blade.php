@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')

<h4 class="mb-4 fw-semibold">Edit Profil</h4>

<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="card">
            <div class="card-body">

                <form method="POST" action="{{ route('profil.update') }}">
                    @csrf

                    {{-- USERNAME --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Username
                        </label>

                        <input type="text"
                               name="username"
                               class="form-control"
                               value="{{ $user->username ?? '' }}"
                               required>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Password Baru
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control">

                        <small class="text-muted">
                            Kosongkan jika tidak diganti
                        </small>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection
