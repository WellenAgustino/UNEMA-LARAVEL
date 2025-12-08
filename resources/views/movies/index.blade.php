@extends('layouts.app')

@section('title', 'UNEMA Cinema - Nonton Film Favorit')

@push('styles')
<style>
    /* Slideshow Styles */
    .slideshow-container {
        position: relative;
        width: 100%;
        height: 75vh;
        min-height: 600px;
        overflow: hidden;
        background: var(--dark-blue);
    }

    .slide {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
        display: flex;
        align-items: flex-end;
    }

    .slide.active {
        opacity: 1;
    }

    .slide-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        z-index: 1;
    }

    .slide-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to right, rgba(13, 17, 28, 0.95) 20%, rgba(13, 17, 28, 0.3) 100%);
        z-index: 2;
    }

    .slide-content {
        position: relative;
        z-index: 3;
        width: 100%;
        padding-bottom: 4rem;
    }

    .slide-info {
        animation: slideInUp 0.8s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .slide-title {
        font-family: 'Pacifico', cursive;
        font-size: 4.5rem;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        color: white;
        margin-bottom: 1rem;
        animation: slideInUp 0.8s ease-out 0.1s both;
    }

    .slide-description {
        font-size: 1.1rem;
        max-width: 500px;
        line-height: 1.7;
        color: #e0e0e0;
        margin-bottom: 2rem;
        animation: slideInUp 0.8s ease-out 0.2s both;
    }

    .slide-buttons {
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideInUp 0.8s ease-out 0.3s both;
    }

    .slide-button {
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .slide-button.primary {
        background: linear-gradient(135deg, #4c8aff, #2a5cdb);
        color: white;
    }

    .slide-button.primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(76, 138, 255, 0.4);
    }

    .slide-button.secondary {
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.5);
        color: white;
    }

    .slide-button.secondary:hover {
        border-color: white;
        background: rgba(255, 255, 255, 0.1);
    }

    .slide-meta {
        display: flex;
        gap: 2rem;
        margin-top: 1.5rem;
        animation: slideInUp 0.8s ease-out 0.4s both;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #b0b0b0;
        font-size: 0.95rem;
    }

    .meta-item i {
        color: var(--primary-color-light);
    }


    .control-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(76, 138, 255, 0.2);
        border: 2px solid var(--primary-color-light);
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .control-btn:hover {
        background: rgba(76, 138, 255, 0.4);
        transform: scale(1.1);
    }

    /* Slideshow Indicators */
    .slideshow-indicators {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        display: flex;
        gap: 0.75rem;
    }

    .indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .indicator.active {
        background: var(--primary-color-light);
        width: 30px;
        border-radius: 6px;
    }

    .indicator:hover {
        background: rgba(255, 255, 255, 0.6);
    }

    /* Movie Info Badge */
    .movie-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(76, 138, 255, 0.2);
        border: 1px solid var(--primary-color-light);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        color: var(--primary-color-light);
        font-size: 0.9rem;
        margin-right: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .slideshow-container {
            height: 60vh; /* Sedikit lebih tinggi agar konten tidak terlalu sempit */
            min-height: 400px;
        }

        .slide-title {
            font-size: 2.2rem; /* Mengurangi ukuran font agar pas di layar kecil */
            line-height: 1.2;
        }

        .slide-description {
            font-size: 0.95rem;
        }

        .slide-buttons {
            flex-direction: column;
            width: 90%; /* Membatasi lebar tombol agar tidak terlalu lebar */
            align-items: flex-start;
        }

        .slide-button {
            width: 100%;
            justify-content: center;
        }

        .slideshow-indicators {
            bottom: 1rem;
        }

        .indicator {
            width: 10px;
            height: 10px;
        }

        .indicator.active {
            width: 25px;
        }

        .slide-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    /* Auto-play animation */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    .autoplay-indicator {
        animation: pulse 1s infinite;
    }
</style>
@endpush

@section('content')

<!-- Animated Slideshow Section -->
@if($topMovies->count() > 0)
    <div class="slideshow-container">
        @foreach($topMovies as $index => $movie)
            <div class="slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                <div class="slide-background" style="background-image: url('{{ $movie->poster_url }}');"></div>
                <div class="slide-overlay"></div>

                <div class="container-fluid slide-content">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-1">
                            <div class="slide-info">
                                <div class="movie-badge">
                                    <i class="bi bi-star-fill"></i>
                                    {{ number_format($movie->rating, 1) }}/5.0
                                </div>
                                <h1 class="slide-title">{{ $movie->title }}</h1>
                                <p class="slide-description">{{ Str::limit($movie->description, 150) }}</p>

                                <div class="slide-meta">
                                    <div class="meta-item">
                                        <i class="bi bi-clock"></i>
                                        <span>{{ $movie->duration }} menit</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-tag"></i>
                                        <span>{{ $movie->genre }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-calendar"></i>
                                        <span>{{ \Carbon\Carbon::parse($movie->release_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <br>
                                <div class="slide-buttons">
                                    <a href="{{ route('movies.show', $movie->id) }}" class="slide-button primary">
                                        <i class="bi bi-play-fill"></i> LIHAT DETAIL
                                    </a>
                                    <a href="{{ route('showtimes.index') }}" class="slide-button secondary">
                                        <i class="bi bi-calendar-check"></i> PESAN TIKET
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- Indicators -->
        <div class="slideshow-indicators">
            @foreach($topMovies as $index => $movie)
                <div class="indicator {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}" title="{{ $movie->title }}"></div>
            @endforeach
        </div>
    </div>
@else
    <!-- Fallback Hero Section -->
    <section class="hero-section index-hero" style="background-image: url('https://via.placeholder.com/1920x600/0d111c/4c8aff?text=UNEMA+CINEMA'); background-size: cover; background-position: center; height: 75vh; min-height: 600px; position: relative; display: flex; align-items: flex-end;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to right, rgba(13, 17, 28, 0.95) 20%, rgba(13, 17, 28, 0.3) 100%); z-index: 1;"></div>

        <div class="container-fluid" style="position: relative; z-index: 2; padding-bottom: 4rem;">
            <div class="row">
                <div class="col-lg-6 offset-lg-1">
                    <h1 style="font-family: 'Pacifico', cursive; font-size: 4.5rem; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); color: white;">UNEMA Cinema</h1>

                    <p class="my-4" style="font-size: 1.1rem; max-width: 500px; line-height: 1.7; color: #e0e0e0;">
                        Nikmati pengalaman menonton film terbaik dengan teknologi sinematik terkini dan kenyamanan maksimal.
                    </p>

                    <div class="d-flex align-items-center gap-3">
                        <a href="#movies" class="btn btn-primary rounded-pill" style="padding: 0.8rem 2rem; font-size: 1.1rem;">
                            <i class="bi bi-play-fill"></i> MULAI MENONTON
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- Movies Section -->
<section id="movies" style="padding: 4rem 0;">
    @livewire('movies-list')
</section>

@push('scripts')
{{-- CDN SweetAlert2 (Wajib ada untuk notifikasi) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- LOGIKA NOTIFIKASI LOGIN SUKSES ---
        // Cek apakah ada session 'success' dari AuthController
        @if (session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#1a1a1a',
                color: '#ffffff',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif
        // --------------------------------------

        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let currentSlide = 0;
        let autoplayInterval;

        // Only initialize if there are slides
        if (slides.length === 0) return;

        function showSlide(n) {
            // Remove active class from all slides and indicators
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));

            // Add active class to current slide and indicator
            slides[n].classList.add('active');
            indicators[n].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
            resetAutoplay();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
            resetAutoplay();
        }

        function goToSlide(n) {
            currentSlide = n;
            showSlide(currentSlide);
            resetAutoplay();
        }

        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }

        function resetAutoplay() {
            clearInterval(autoplayInterval);
            startAutoplay();
        }

        // Event listeners
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => goToSlide(index));
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') prevSlide();
            if (e.key === 'ArrowRight') nextSlide();
        });

        // Start autoplay
        startAutoplay();

        // Pause autoplay on hover
        const slideshowContainer = document.querySelector('.slideshow-container');
        if (slideshowContainer) {
            slideshowContainer.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
            slideshowContainer.addEventListener('mouseleave', startAutoplay);
        }
    });
</script>
@endpush

@endsection
