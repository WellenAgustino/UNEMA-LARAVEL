<aside class="sidebar">
    {{-- Container Logo: Akan disembunyikan di Mobile oleh CSS --}}
    <div class="sidebar-logo-container">
        <a href="{{ url('/') }}" style="display: block; text-align: center;">
            @if(file_exists(public_path('logo.png')))
                <img src="{{ asset('logo.png') }}" alt="Nema Logo" class="logo-nema"
                      style="max-width: 100%; max-height: 40px; height: auto; object-fit: contain;">
            @else
                <div class="logo-placeholder" style="width: 50px; height: 50px; background: var(--primary-gradient); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.8rem;">
                    NEMA
                </div>
            @endif
        </a>
    </div>

    {{-- Menu Utama --}}
    <nav class="nav flex-column w-100">
        <a class="nav-link {{ Request::routeIs('home', 'movies.show', 'select-seats') ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="bi bi-film"></i>
            <span>MOVIE</span>
        </a>
        <a class="nav-link {{ Request::routeIs('showtimes.*') ? 'active' : '' }}" href="{{ route('showtimes.index') }}">
            <i class="bi bi-clock"></i>
            <span>SHOWTIME</span>
        </a>
        @auth
        <a class="nav-link {{ Request::routeIs('tickets.*') ? 'active' : '' }}" href="{{ route('tickets.index') }}">
            <i class="bi bi-ticket-perforated"></i>
            <span>TICKET</span>
        </a>
        @endauth

        {{-- Admin Menu --}}
        @if(auth()->check() && auth()->user()->is_admin)
            <a class="nav-link {{ Request::is('admin*') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-shield-lock"></i>
                <span>ADMIN</span>
            </a>
        @endif
    </nav>

    {{-- Menu Bawah (Settings/Auth) --}}
    <div class="mt-auto w-100 d-flex flex-column align-items-center bottom-menu-group">
        @auth
            <a class="nav-link {{ Request::routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}">
                <i class="bi bi-gear"></i>
                <span class="d-none d-lg-block d-md-block">SETTING</span>
            </a>
            <a class="nav-link text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="bi bi-box-arrow-right"></i>
                <span class="d-none d-lg-block d-md-block">LOGOUT</span>
            </a>
        @else
            <a class="nav-link {{ Request::routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>LOGIN</span>
            </a>
        @endauth
    </div>
</aside>
