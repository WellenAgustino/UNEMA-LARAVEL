@push('styles')
<style>
    .form-control-dark {
        background: var(--medium-blue);
        border-color: var(--light-blue);
        color: var(--text-color);
    }
    .form-control-dark::placeholder {
        color: var(--text-muted);
        opacity: 1; /* Override default browser opacity */
    }
    .form-control-dark:focus {
        background: var(--medium-blue);
        border-color: var(--primary-color-light);
        color: var(--text-color);
        box-shadow: 0 0 0 0.2rem rgba(76, 138, 255, 0.25);
    }
    /* Kustomisasi untuk Dark Theme */
    .pagination .page-link {
        background-color: var(--dark-blue);
        border-color: var(--light-blue);
        color: var(--text-color);
    }
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color); /* Anda bisa ganti dengan warna primer Anda */
        border-color: var(--primary-color);
        color: #fff;
    }
    .pagination .page-item.disabled .page-link {
        background-color: var(--medium-blue);
        border-color: var(--light-blue);
        color: #6c757d; /* Warna teks abu-abu */
    }
    .pagination .page-link:hover {
        background-color: var(--medium-blue);
    }
</style>
@endpush

<div class="container-fluid px-5 py-5">
    <h1 class="section-title mb-4">Cari Film</h1>

    <!-- Filter Section -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <input type="text" wire:model.live="search" placeholder="Cari judul film..."
                class="form-control form-control-dark">
        </div>
        <div class="col-md-2">
            <select wire:model.live="genre" class="form-select form-control-dark">
                <option value="">Semua Genre</option>
                @foreach($genres as $g)
                    <option value="{{ $g }}">{{ $g }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="status" class="form-select form-control-dark">
                <option value="now_showing">Sedang Tayang</option>
                <option value="coming_soon">Segera Hadir</option>
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="sortBy" class="form-select form-control-dark">
                <option value="rating">Rating Tertinggi</option>
                <option value="title">Judul (A-Z)</option>
                <option value="created_at">Terbaru</option>
            </select>
        </div>
    </div>

    <!-- Loading State -->
    <div wire:loading class="alert alert-info">
        <i class="bi bi-hourglass-split"></i> Memuat data...
    </div>

    <!-- Movies Grid -->
    <div wire:loading.remove>
        @if($movies->count() > 0)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                @foreach ($movies as $movie)
                <div class="col">
                    <a href="{{ route('movies.show', $movie->id) }}" class="text-decoration-none">
                        <div class="card h-100 movie-card overflow-hidden">
                            <img src="{{ $movie->poster_url }}" class="card-img-top" alt="{{ $movie->title }}" style="height: 400px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-truncate" style="color: var(--text-color);">{{ $movie->title }}</h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge rounded-pill" style="background-color: var(--light-blue); color: var(--primary-color-light);">{{ $movie->genre }}</span>
                                    <span class="fw-bold" style="color: #ffd700;"><i class="bi bi-star-fill"></i> {{ $movie->rating }}</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <div class="btn btn-primary w-100">Pesan Tiket</div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $movies->links('pagination::bootstrap-5') }}
        </div>
        @else
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle"></i> Tidak ada film yang sesuai dengan pencarian Anda.
            </div>
        @endif
    </div>
</div>
