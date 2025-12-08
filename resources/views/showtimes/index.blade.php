@extends('layouts.app')

@section('title', 'Jadwal Tayang - UNEMA Cinema')

@push('styles')
<style>
    /* --- Base Styles --- */
    .date-filter-btn {
        background: var(--medium-blue);
        border: 2px solid var(--light-blue);
        color: var(--text-color);
        padding: 0.8rem 1rem; /* Sedikit disesuaikan untuk mobile */
        border-radius: 10px;
        transition: all 0.3s;
        cursor: pointer;
        min-width: 100px; /* Sedikit dikecilkan untuk mobile */
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    /* Desktop adjustment */
    @media (min-width: 768px) {
        .date-filter-btn {
            padding: 1rem;
            min-width: 120px;
        }
    }

    .date-filter-btn:hover {
        border-color: var(--primary-color-light);
        background: rgba(76, 138, 255, 0.1);
    }
    .date-filter-btn.active {
        background: linear-gradient(135deg, #4c8aff, #2a5cdb);
        color: #fff;
    }

    .showtime-badge {
        background: var(--medium-blue);
        border: 1px solid var(--primary-color-light);
        padding: 0.5rem 1rem; /* Mobile friendly padding */
        border-radius: 8px;
        display: inline-block;
        transition: 0.3s;
        color: var(--text-color);
        width: 100%; /* Full width on very small screens, overridden by flex layout */
        max-width: fit-content;
    }
    /* Desktop specific padding */
    @media (min-width: 768px) {
        .showtime-badge {
            padding: 0.75rem 1.25rem;
        }
    }

    .showtime-badge:hover {
        background: linear-gradient(135deg, #4c8aff, #2a5cdb);
        color: white;
        box-shadow: 0 4px 12px rgba(76, 138, 255, 0.3);
        transform: translateY(-2px);
    }

    .seats-indicator.low { color: #ff6b6b; }
    .seats-indicator.medium { color: #ffd93d; }
    .seats-indicator.high { color: #6bcf7f; }

    .movie-card {
        background: var(--medium-blue);
        border: 1px solid var(--light-blue);
        border-radius: 15px;
        transition: 0.3s;
        overflow: hidden; /* Penting agar poster tidak keluar border */
    }
    .movie-card:hover {
        border-color: var(--primary-color-light);
        box-shadow: 0 5px 20px rgba(76, 138, 255, 0.2);
    }

    .movie-poster {
        width: 100%;
        object-fit: cover;
    }

    /* --- Responsive Poster Logic --- */
    @media (max-width: 767.98px) {
        /* Tampilan Mobile: Gambar di atas */
        .movie-poster {
            height: 300px; /* Batasi tinggi agar tidak memenuhi layar */
            border-radius: 15px 15px 0 0;
            object-position: top;
        }
        /* Select box full width di mobile */
        .genre-filter {
            width: 100% !important;
        }
    }
    @media (min-width: 768px) {
        /* Tampilan Desktop: Gambar di kiri */
        .movie-poster {
            height: 100%;
            border-radius: 15px 0 0 15px;
            min-height: 250px;
        }
        .genre-filter {
            width: 200px;
        }
    }

    .card-title { color: white; }
    .text-muted { color: rgba(255, 255, 255, 0.7) !important; }

    .badge {
        background-color: var(--light-blue) !important;
        color: var(--text-color);
    }

    .genre-filter {
        background: var(--dark-blue);
        border-color: var(--light-blue);
        color: var(--text-color);
    }
    .genre-filter:focus {
        border-color: var(--primary-color-light);
        box-shadow: 0 0 0 0.2rem rgba(76, 138, 255, 0.25);
    }

    .alert-info {
        background: rgba(76, 138, 255, 0.1);
        border-color: var(--primary-color-light);
        color: var(--text-color);
    }
    
    /* Custom Scrollbar hide for cleaner look on mobile */
    .overflow-auto::-webkit-scrollbar {
        height: 6px;
    }
    .overflow-auto::-webkit-scrollbar-thumb {
        background: var(--light-blue);
        border-radius: 3px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-3 p-md-5">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h1 class="section-title mb-0">Jadwal Tayang</h1>

        <select class="form-select genre-filter" id="genreFilter">
            <option value="all">Semua Genre</option>
            @foreach($genres as $genre)
                <option value="{{ $genre }}" {{ request('genre') === $genre ? 'selected' : '' }}>
                    {{ $genre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4 overflow-auto">
        <div class="d-flex gap-2 gap-md-3 pb-2" style="min-width:max-content;">
            @foreach($availableDates as $date)
                <a href="{{ route('showtimes.index', ['date' => $date, 'genre' => request('genre', 'all')]) }}"
                   class="date-filter-btn {{ $date === $selectedDate ? 'active' : '' }}">
                    <div class="fw-bold">
                        @php $dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; @endphp
                        {{ $dayNames[\Carbon\Carbon::parse($date)->dayOfWeek] }}
                    </div>
                    <div class="fs-4">{{ \Carbon\Carbon::parse($date)->format('d') }}</div>
                    <div class="small">{{ \Carbon\Carbon::parse($date)->format('M') }}</div>
                </a>
            @endforeach
        </div>
    </div>

    @if(empty($moviesByDate))
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle fs-3 d-block mb-3"></i>
            <h5>Tidak ada jadwal tayang</h5>
            <p>Coba tanggal atau genre lain.</p>
        </div>

    @else

        <h3 class="text-primary mb-4 fs-4 fs-md-3">
            <i class="bi bi-calendar-event me-2"></i>
            @php
                $dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                $dayObj = \Carbon\Carbon::parse($selectedDate);
                echo $dayNames[$dayObj->dayOfWeek] . ', ' . $dayObj->format('d F Y');
            @endphp
        </h3>

        @foreach($moviesByDate as $movieId => $data)
        <div class="card movie-card mb-4">
            <div class="row g-0">

                <div class="col-12 col-md-3 col-lg-2">
                    <img src="{{ $data['details']['poster_url'] }}"
                         class="img-fluid movie-poster"
                         alt="{{ $data['details']['title'] }}">
                </div>

                <div class="col-12 col-md-9 col-lg-10">
                    <div class="card-body p-3 p-md-4">

                        <h4 class="card-title fw-bold">{{ $data['details']['title'] }}</h4>

                        <div class="d-flex flex-wrap gap-3 align-items-center text-muted mb-3 small-md-normal">
                            <span class="badge rounded-pill">{{ $data['details']['genre'] }}</span>
                            <span><i class="bi bi-clock"></i> {{ $data['details']['duration'] }} menit</span>
                            <span class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                {{ $data['details']['rating'] }}
                            </span>
                        </div>

                        <hr style="border-color: var(--light-blue);">

                        <div class="row">
                            @php
                                $byStudio = [];
                                foreach ($data['schedules'] as $s) {
                                    $byStudio[$s['studio']][] = $s;
                                }
                            @endphp

                            @foreach($byStudio as $studio => $times)
                            <div class="col-12 col-md-6 mb-3">

                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-tv me-2 text-primary"></i>
                                        <strong class="text-white">{{ $studio }}</strong>
                                    </div>

                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($times as $schedule)

                                        @php
                                            $available = $schedule->available_seats;
                                            $total = $schedule->total_seats;
                                            $percentage = ($available / $total) * 100;
                                            $seatsClass = $percentage < 20 ? 'low' : ($percentage < 50 ? 'medium' : 'high');
                                        @endphp

                                        @if($available > 0)
                                            <a href="{{ route('select-seats', $schedule->id) }}"
                                               class="showtime-badge text-decoration-none">
                                                <div class="fw-bold fs-5">
                                                    {{ \Carbon\Carbon::parse($schedule->show_time)->format('H:i') }}
                                                </div>
                                                <div class="small text-muted">
                                                    Rp {{ number_format($schedule->price, 0, ',', '.') }}
                                                </div>
                                                <div class="seats-indicator {{ $seatsClass }}">
                                                    <i class="bi bi-people-fill"></i>
                                                    {{ $available }}/{{ $total }}
                                                </div>
                                            </a>
                                        @else
                                            <div class="showtime-badge" style="opacity:0.5;">
                                                <div class="fw-bold text-danger">Tiket Habis</div>
                                                <div class="small text-muted">Sesi penuh</div>
                                            </div>
                                        @endif

                                    @endforeach
                                </div>

                            </div>
                            @endforeach

                        </div>

                    </div>
                </div>

            </div>
        </div>
        @endforeach

    @endif
</div>

<script>
    document.getElementById('genreFilter').addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('genre', this.value);
        url.searchParams.set('date', '{{ $selectedDate }}');
        window.location.href = url.toString();
    });
</script>
@endsection