<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UNEMA Cinema - Daftar Akun</title>
    
    {{-- PERBAIKAN: Tipe icon disesuaikan untuk file .png --}}
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@400;600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
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
                <span></span><span></span><span></span><span></span><span></span>
            </div>
            
            <div class="login-header">
                <h2>Buat Akun Baru</h2>
                <p>Daftar untuk menjadi anggota UNEMA</p>
            </div>

            {{-- 
                PERBAIKAN: Blok error ini dihapus karena duplikat.
                Penanganan error yang lebih baik adalah @error di bawah setiap input.
            --}}
            {{-- @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif --}}

            {{-- 
                PERBAIKAN: Menambahkan onsubmit untuk UX tombol loading
                dan mencegah double-click.
            --}}
            <form id="registerForm" method="POST" action="{{ route('register') }}" onsubmit="disableRegisterButton()">
                @csrf
                <div class="input-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input type="text" id="username" name="username" placeholder="Pilih username unik" value="{{ old('username') }}" class="@error('username') is-invalid @enderror" required>
                        <i class="fas fa-user"></i>
                    </div>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" required>
                        <i class="fas fa-envelope"></i>
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Buat password baru" class="@error('password') is-invalid @enderror" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        {{-- PERBAIKAN: Menambahkan class @error --}}
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password Anda" class="@error('password_confirmation') is-invalid @enderror" required>
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    {{-- PERBAIKAN: Menambahkan blok @error --}}
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn-login" id="registerBtn">
                    <i class="fas fa-user-plus"></i>
                    <span id="registerBtnText">Daftar Sekarang</span>
                </button>
            </form>
            
            <div class="register-link">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di Sini</a></p>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menonaktifkan tombol saat form disubmit
        function disableRegisterButton() {
            const btn = document.getElementById('registerBtn');
            const btnText = document.getElementById('registerBtnText');
            
            btn.disabled = true;
            btnText.innerText = 'Memproses...';
            
            // Anda bisa mengganti ikon juga jika mau
            // btn.querySelector('i').className = 'fas fa-spinner fa-spin';
        }
    </script>
    
    {{-- Jika Anda punya file auth.js, Anda bisa pindahkan script di atas ke sana --}}
    {{-- <script src="{{ asset('js/auth.js') }}"></script> --}}
</body>
</html>