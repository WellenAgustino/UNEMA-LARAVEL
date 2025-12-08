@extends('layouts.app')

@section('title', 'Pengaturan - UNEMA Cinema')

@push('styles')
<style>
    .form-control-dark {
        background: var(--medium-blue);
        border-color: var(--light-blue);
        color: var(--text-color);
    }
    .form-control-dark::placeholder {
        color: var(--text-muted);
        opacity: 1;
    }
    .form-control-dark:focus {
        background: var(--medium-blue);
        border-color: var(--primary-color-light);
        color: var(--text-color);
        box-shadow: 0 0 0 0.2rem rgba(76, 138, 255, 0.25);
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-4 p-md-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="section-title mb-2">Pengaturan Akun</h1>
            <p class="text-white">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="panel-card">
                <form method="POST" action="{{ route('settings') }}">
                    @csrf
                    @method('PUT')

                    {{-- Informasi Profil --}}
                    <h5 class="text-primary mb-4"><i class="bi bi-person-circle me-2"></i>Informasi Profil</h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" class="form-control form-control-dark" value="{{ $user->username }}" disabled>
                            <small class="form-text form-label">Username tidak dapat diubah.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-dark @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Nama Lengkap</label>
                            <input type="text" id="full_name" name="full_name" class="form-control form-control-dark @error('full_name') is-invalid @enderror" value="{{ old('full_name', $user->full_name) }}" placeholder="Masukkan nama lengkap Anda">
                            @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone" class="form-control form-control-dark @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: var(--light-blue);">

                    {{-- Ubah Password --}}
                    <h5 class="text-primary mb-4"><i class="bi bi-shield-lock me-2"></i>Ubah Password</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" id="password" name="password" class="form-control form-control-dark @error('password') is-invalid @enderror" placeholder="Masukkan password baru">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text form-label">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-dark" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="mt-5 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
