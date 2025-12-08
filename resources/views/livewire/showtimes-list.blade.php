<div class="container-fluid px-5 py-5">
    <h1 class="section-title mb-4">Jadwal Tayang</h1>

    <!-- Filter Section -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <input
                type="text"
                wire:model.live="searchMovie"
                placeholder="Cari judul film..."
                class="form-control"
                style="background: var(--medium-blue); border-color: var(--light-blue); color: var(--text-color);"
            >
        </div>
        <div class="col-md-3">
            <select
                wire:model.live="movieId"
                class="form-select"
                style="background: var(--medium-blue); border-color: var(--light-blue); color: var(--text-color);"
            >
                <option value="">Semua Film</option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select
                wire:model.live="selectedDate"
                class="form-select"
                style="background: var(--medium-blue); border-color: var(--light-blue); color: var(--text-color);"
            >
                <option value="">Semua Tanggal</option>
                @foreach($upcomingDates as $date)
                    <option value="{{ $date }}">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Loading State -->
    <div wire:loading class="alert alert-info">
        <i class="bi bi-hourglass-split"></i> Memuat jadwal...
    </div>

    <!-- Showtimes Grid -->
    <div wire:loading.remove>
        @if($showtimes->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($showtimes as $showtime)
                    <div class="col">
                        <div class="card h-100" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $showtime->movie->title }}</h5>
                                <div class="mb-3">
                                    <p class="mb-1"><i class="bi bi-calendar-event"></i> {{ $showtime->show_date->format('d M Y') }}</p>
                                    <p class="mb-1"><i class="bi bi-clock"></i> {{ $showtime->show_time }}</p>
                                    <p class="mb-1"><i class="bi bi-building"></i> Studio {{ $showtime->studio }}</p>
                                    <p class="mb-1"><i class="bi bi-chair"></i> Kursi Tersedia: {{ $showtime->available_seats }}</p>
                                    <p class="mb-0"><strong style="color: #ffd700;">Rp {{ number_format($showtime->price, 0, ',', '.') }}</strong></p>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                @auth
                                    <a href="{{ route('select-seats', $showtime->id) }}" class="btn btn-primary w-100">
                                        <i class="bi bi-ticket-perforated"></i> Pesan Tiket
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                        <i class="bi bi-box-arrow-in-right"></i> Login untuk Pesan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $showtimes->links() }}
            </div>
        @else
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle"></i> Tidak ada jadwal tayang yang tersedia.
            </div>
        @endif
    </div>
</div>
