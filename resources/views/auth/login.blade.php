<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UNEMA Cinema - Login</title>

    <link rel="icon" href="logo.png" type="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@400;600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

    <video autoplay muted loop playsinline id="video-background" preload="auto">
        <source src="https://assets.mixkit.co/videos/preview/mixkit-bright-light-leaks-1025-large.mp4" type="video/mp4">
    </video>

    <div class="spotlight spotlight-1"></div>
    <div class="spotlight spotlight-2"></div>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="ticket-top"></div>
            <div class="ticket-bottom"></div>
            <div class="ticket-barcode">
                <span></span><span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span><span></span>
            </div>

            <div class="login-header">
                <h2>Selamat Datang Kembali</h2>
                <p>Masuk untuk melanjutkan pengalaman menonton Anda</p>
            </div>

            {{-- Form Login --}}
            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        {{-- value="{{ old('email') }}" PENTING agar email tidak hilang saat refresh --}}
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda"
                               value="{{ old('email') }}" required autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                    {{-- Error Inline (Opsional) --}}
                    @error('email')
                        <small style="color: #ff4b4b; margin-top: 5px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <div class="options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Ingat Saya</span>
                    </label>
                    <a href="#" class="forgot-password">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Masuk Sekarang</span>
                </button>
            </form>

            <div class="register-link">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>

    {{-- Hapus JS Auth custom jika mengganggu submit form standar, atau pastikan tidak ada e.preventDefault() --}}
    {{-- <script src="{{ asset('js/auth.js') }}"></script> --}}

    {{-- LOGIC NOTIFIKASI ERROR --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Konfigurasi Toast (Notifikasi Kecil)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end', // Posisi: top-end, top-center, bottom-end, dll
            showConfirmButton: false,
            timer: 3000, // Waktu tampil (3 detik)
            timerProgressBar: true,
            background: '#1a1a1a', // Warna background gelap
            color: '#ffffff',      // Warna teks putih
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // 1. Notifikasi Error Login (Password/Email Salah)
        @if (session('loginError'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('loginError') }}"
            });
        @endif

        // 2. Notifikasi Validasi Error (Format Email Salah/Kosong)
        @if ($errors->any())
            Toast.fire({
                icon: 'warning',
                title: 'Periksa kembali input Anda!'
            });
        @endif

        // 3. Notifikasi Sukses Register
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif
    }); 
</script>
</body>
</html>
