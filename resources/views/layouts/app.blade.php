<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UNEMA Cinema')</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        :root {
            --primary-color-light: #4c8aff;
            --primary-color-dark: #0056b3;
            --primary-gradient: linear-gradient(to right, var(--primary-color-light), var(--primary-color-dark));
            --dark-blue: #0d111c;
            --medium-blue: #161b29;
            --light-blue: #2c3a58;
            --text-color: #e0e0e0;
            --text-muted: #8899aa;
            --text-secondary: #a0b0c0;
            --sidebar-width: 90px;
            --bottom-bar-height: 70px;
        }

        body {
            background-color: var(--dark-blue);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* --- LAYOUT UTAMA --- */
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            padding: 2rem;
            transition: all 0.3s ease;
        }

        /* --- SIDEBAR DESKTOP --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--medium-blue);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 1.5rem;
            border-right: 1px solid var(--light-blue);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        /* Container Logo */
        .sidebar-logo-container {
            margin-bottom: 2rem;
            width: 100%;
            padding: 0 10px;
            display: flex;
            justify-content: center;
        }

        /* Link Styles */
        .sidebar .nav-link {
            color: var(--text-muted);
            text-align: center;
            font-size: 0.75rem;
            padding: 1rem 0;
            width: 100%;
            border-left: 3px solid transparent; /* Indikator Desktop */
            border-top: 3px solid transparent;  /* Reset untuk Mobile */
            border-radius: 0;
            transition: all 0.2s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .sidebar .nav-link i {
            font-size: 1.5rem;
            margin-bottom: 0.3rem;
            transition: transform 0.2s;
        }

        .sidebar .nav-link span {
            font-size: 0.7rem;
            font-weight: 500;
        }

        /* Active & Hover States */
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: var(--primary-color-light);
            background-color: rgba(76, 138, 255, 0.05);
            border-left-color: var(--primary-color-light);
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }

        /* --- UTILITIES --- */
        .section-title {
            color: var(--primary-color-light);
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .movie-card {
            background-color: var(--medium-blue);
            border: 1px solid var(--light-blue);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .movie-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(76, 138, 255, 0.3);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border-color: var(--primary-color-dark);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 86, 179, 0.4);
            color: #ffffff;
        }

        .panel-card {
            background: var(--medium-blue);
            border: 1px solid var(--light-blue);
            border-radius: 15px;
            padding: 2rem;
        }

        .form-label {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .form-control {
            background-color: var(--dark-blue);
            border: 1px solid var(--light-blue);
            color: var(--text-color);
            border-radius: .5rem;
            padding: .75rem 1rem;
        }

        .form-control:focus {
            background-color: var(--dark-blue);
            color: var(--text-color);
            border-color: var(--primary-color-light);
            box-shadow: 0 0 0 0.2rem rgba(76, 138, 255, 0.25);
        }

        .form-control:disabled, .form-control[readonly] {
            background-color: #212633;
            opacity: 0.7;
        }

        /* --- MOBILE RESPONSIVE (BOTTOM BAR) --- */
        @media (max-width: 992px) {
            /* Reset Layout Konten Utama */
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
                padding-bottom: calc(var(--bottom-bar-height) + 30px); /* Ruang ekstra agar tidak tertutup bar */
            }

            /* Sidebar berubah menjadi Bottom Bar */
            .sidebar {
                width: 100%;
                height: var(--bottom-bar-height);
                min-height: auto;
                top: auto;
                bottom: 0;
                flex-direction: row; /* Horizontal */
                justify-content: space-between;
                padding: 0;
                border-right: none;
                border-top: 1px solid var(--light-blue);
                box-shadow: 0 -5px 20px rgba(0,0,0,0.5);
                background-color: var(--medium-blue);
            }

            /* Sembunyikan Logo di Mobile */
            .sidebar-logo-container {
                display: none;
            }

            /* Atur Container Navigasi agar horizontal */
            .sidebar .nav {
                flex-direction: row !important; /* Paksa row */
                align-items: center;
                justify-content: space-around;
                height: 100%;
                width: auto;
                flex-grow: 1;
            }

            /* Container Menu Bawah (Settings/Logout) */
            .sidebar .bottom-menu-group {
                flex-direction: row !important;
                width: auto !important;
                margin-top: 0 !important;
                border-left: 1px solid var(--light-blue);
                padding-left: 5px;
                padding-right: 5px;
                height: 100%;
                align-items: center;
                justify-content: center;
            }

            /* Link Styling di Mobile */
            .sidebar .nav-link {
                padding: 0.5rem;
                height: 100%;
                border-left: none; /* Hapus border samping */
                border-top: 3px solid transparent; /* Pindah indikator ke atas */
                width: auto;
                min-width: 60px; /* Area sentuh */
            }

            /* Sembunyikan teks label di layar HP kecil */
            @media (max-width: 480px) {
                .sidebar .nav-link span {
                    display: none;
                }
                .sidebar .nav-link i {
                    margin-bottom: 0;
                    font-size: 1.4rem;
                }
            }

            /* Active State Mobile (Garis di atas) */
            .sidebar .nav-link.active,
            .sidebar .nav-link:hover {
                border-left: none;
                border-top-color: var(--primary-color-light);
                background: linear-gradient(to bottom, rgba(76, 138, 255, 0.1), transparent);
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="main-wrapper">
        @include('layouts.sidebar')

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    @stack('scripts')

    {{-- Modal Konfirmasi Logout --}}
    @auth
        <x-confirm-modal
            modalId="logoutModal"
            title="Konfirmasi Logout"
            body="Apakah Anda yakin ingin keluar dari sesi ini?"
            confirmText="Logout"
            cancelText="Batal"
            :confirmAction="route('logout')"
            confirmMethod="POST"
            iconClass="bi-box-arrow-right text-warning"
            confirmButtonClass="btn-danger"
        />
    @endauth
</body>
</html>
