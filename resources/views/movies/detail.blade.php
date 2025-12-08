@extends('layouts.app')

@section('title', $movie->title . ' - UNEMA Cinema')

@section('content')

<section class="hero-section detail-hero" style="background-image: url('{{ $movie->poster_url }}'); background-size: cover; background-position: center; height: 80vh; position: relative; display: flex; align-items: flex-end;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to top, rgba(13, 17, 28, 1) 10%, rgba(13, 17, 28, 0.3) 100%); z-index: 1;"></div>

    <div class="container" style="position: relative; z-index: 2; padding-bottom: 4rem;">
        <div class="col-lg-8">
            <h1 style="font-family: 'Pacifico', cursive; font-size: 4.5rem; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); color: white;">{{ $movie->title }}</h1>
            <div class="d-flex align-items-center gap-4 my-3 detail-meta" style="color: rgba(255,255,255,0.8);">
                <div style="font-size: 1.5rem; color: #ffd700;">
                    <i class="bi bi-star-fill"></i>
                    <span id="avgRatingValue">{{ number_format($avgRating, 1) }}</span>
                </div>
                <span>{{ $movie->genre }}</span>
                <span><i class="bi bi-clock"></i> {{ $movie->duration }} Menit</span>
                <span><i class="bi bi-calendar-event"></i> {{ $movie->release_date->format('Y') }}</span>
            </div>
            <p class="lead" style="font-size: 1.1rem; max-width: 500px; line-height: 1.7; color: #e0e0e0;">{{ $movie->description }}</p>

            <div class="d-flex align-items-center gap-3 mt-4 detail-buttons">
                <a href="{{ route('showtimes.index') }}?movie_id={{ $movie->id }}" class="btn btn-primary rounded-pill btn-lg">
                    <i class="bi bi-ticket-perforated-fill"></i> Pesan Tiket
                </a>
                @if (!empty($movie->trailer_url))
                    <a href="#" class="btn btn-outline-primary rounded-pill btn-lg" data-bs-toggle="modal" data-bs-target="#trailerModal" data-trailer-url="{{ $movie->trailer_url }}">
                        <i class="bi bi-play-fill"></i> LIHAT TRAILER
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="container-fluid my-5 px-lg-5">
    <div class="row">
        <div class="col-12">
            @livewire('movie-reviews', ['movieId' => $movie->id])
        </div>
    </div>
</div>

<div class="modal fade" id="trailerModal" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
            <div class="modal-header" style="border-color: var(--light-blue);">
                <h5 class="modal-title" style="color: var(--text-color);">Trailer Film</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="trailerFrame" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const trailerModal = document.getElementById('trailerModal');
    const trailerFrame = document.getElementById('trailerFrame');

    /**
     * Fungsi helper untuk mengekstrak ID Video YouTube dari berbagai format URL.
     * @param {string} url - URL YouTube (bisa 'watch?v=' atau 'youtu.be')
     * @returns {string|null} - ID Video atau null jika tidak ditemukan
     */
    function getYouTubeVideoId(url) {
        let videoId = null;
        try {
            // Gunakan URL API bawaan browser untuk parsing
            const urlObj = new URL(url);
            const hostname = urlObj.hostname;

            if (hostname === 'youtu.be') {
                // Handle short URLs: https://youtu.be/VIDEO_ID
                videoId = urlObj.pathname.substring(1); // Menghapus '/' di awal
            } else if (hostname === 'www.youtube.com' || hostname === 'youtube.com') {
                // Handle long URLs: https://www.youtube.com/watch?v=VIDEO_ID
                if (urlObj.pathname === '/watch') {
                    videoId = urlObj.searchParams.get('v');
                }
                // Handle jika URL-nya sudah embed: https://www.youtube.com/embed/VIDEO_ID
                if (urlObj.pathname.startsWith('/embed/')) {
                    videoId = urlObj.pathname.substring(7); // Menghapus '/embed/'
                }
            }
        } catch (e) {
            console.error('Error parsing trailer URL:', e);
            return null;
        }

        // Membersihkan ID dari parameter tambahan (misal ?t=10s)
        return videoId ? videoId.split('?')[0].split('&')[0] : null;
    }

    trailerModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const trailerUrl = button.getAttribute('data-trailer-url');

        if (trailerUrl) {
            const videoId = getYouTubeVideoId(trailerUrl);

            if (videoId) {
                // 1. Buat URL embed yang dijamin benar dari Video ID
                const finalUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1`;

                // 2. Set src iframe
                trailerFrame.setAttribute('src', finalUrl);
            } else {
                console.error('Tidak bisa mengekstrak Video ID dari:', trailerUrl);
                trailerFrame.setAttribute('src', ''); // Kosongkan jika URL salah
            }
        }
    });

    trailerModal.addEventListener('hide.bs.modal', event => {
        // Ini sudah benar, menghentikan video saat modal ditutup
        trailerFrame.setAttribute('src', '');
    });

    // Menangkap event dari Livewire untuk update rating secara real-time
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('reviewUpdated', (event) => {
            const avgRatingValueElement = document.getElementById('avgRatingValue');
            const newRating = parseFloat(event.avgRating).toFixed(1);
            avgRatingValueElement.innerText = newRating;
        });
    });
</script>
@endpush

@push('styles')
<style>
    /* Default state for buttons */
    .detail-buttons .btn {
        width: auto;
        min-width: 200px; /* Memberi lebar minimum pada desktop */
    }

    /* Responsive adjustments for mobile devices */
    @media (max-width: 768px) {
        .detail-hero {
            height: auto; /* Tinggi hero section menyesuaikan konten */
            min-height: 80vh;
            padding-top: 5rem; /* Menambah padding atas agar tidak terlalu mepet */
        }

        .detail-hero h1 {
            font-size: 2.5rem; /* Mengurangi ukuran font judul */
        }

        .detail-hero .lead {
            font-size: 0.95rem; /* Mengurangi ukuran font deskripsi */
        }

        .detail-meta {
            flex-wrap: wrap; /* Izinkan item meta untuk wrap ke baris baru */
            gap: 1rem !important; /* Mengurangi jarak antar item */
        }

        .detail-buttons {
            flex-direction: column; /* Susun tombol secara vertikal */
            width: 100%; /* Gunakan lebar penuh */
        }

        .detail-buttons .btn {
            width: 100%; /* Tombol menjadi lebar penuh */
        }
    }
</style>
@endpush
