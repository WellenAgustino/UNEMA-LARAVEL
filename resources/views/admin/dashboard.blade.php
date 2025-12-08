@extends('layouts.app')
@section('title', 'Admin Panel - UNEMA Cinema')
@push('styles')
<link rel="icon" href="logo.png" type="icon">
<style>
    /* PERBAIKAN 1: Menambahkan CSS untuk text-muted agar terlihat 
    */
    .main-content .text-muted {
        color: rgba(255, 255, 255, 0.7) !important; 
    }

    /* Style untuk Panel Manajemen */
    .panel-card {
        background: var(--medium-blue);
        border: 1px solid var(--light-blue);
        border-radius: 15px;
        padding: 2rem;
    }
    .nav-tabs .nav-link {
        background-color: transparent;
        border-color: var(--light-blue);
        color: var(--text-muted);
        border-top-left-radius: .5rem;
        border-top-right-radius: .5rem;
    }
    .nav-tabs .nav-link.active {
        color: var(--primary-color-light);
        background-color: var(--medium-blue);
        border-bottom-color: var(--medium-blue);
        font-weight: bold;
    }
    .table-dark {
        color: #fff;
    }
    .table-dark small, .table-dark .text-muted {
        color: #ccc;
    }
    .poster-img {
        width: 50px;
        height: 75px;
        object-fit: cover;
        border-radius: 5px;
    }
    .badge {
        padding: 0.4em 0.7em;
        font-size: 0.8em;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--medium-blue), var(--light-blue));
        border: 1px solid var(--primary-color-light);
        border-radius: 15px;
        padding: 2rem;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(76, 138, 255, 0.3);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }
    .stat-value {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--primary-color-light);
        margin-bottom: 0.5rem;
    }
    .stat-label {
        color: var(--text-muted); /* Ini akan terpengaruh oleh CSS perbaikan di atas */
        font-size: 0.95rem;
    }
    .quick-action-card {
        background: var(--medium-blue);
        border: 1px solid var(--light-blue);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
        height: 100%;
    }
    .quick-action-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary-color-light);
        background: rgba(76, 138, 255, 0.1);
    }
    .quick-action-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--primary-color-light);
    }
    
    /* PERBAIKAN 2: Menambahkan style untuk kartu 'Recent Bookings' & 'Popular Movies' 
    */
    .card.movie-card {
        background: var(--medium-blue);
        border: 1px solid var(--light-blue);
        border-radius: 15px; /* Menyamakan dengan style kartu lainnya */
        height: 100%;
    }
    
    .recent-table {
        background: var(--medium-blue);
        border-radius: 15px;
        overflow: hidden;
    }
    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
    }
    /* Memastikan teks putih di tabel */
    .table-dark {
        color: #fff;
    }
    .table-dark small, .table-dark .text-muted {
        color: #ccc; /* Pastikan text-muted di tabel juga terang */
    }

    /* PERBAIKAN 3: Media Query untuk Mobile */
    @media (max-width: 768px) {
        .main-content {
            padding: 1.5rem !important; /* Mengurangi padding di mobile */
        }
        .stat-card {
            padding: 1.5rem;
        }
        .stat-value {
            font-size: 2rem; /* Ukuran font statistik lebih kecil */
        }
        .panel-card { padding: 1.5rem; }
    }
</style>
@endpush


@section('content')
<div class="container-fluid p-3 p-lg-5 main-content">
    {{-- ==================================================================== --}}
    {{-- BREADCRUMB NAVIGATION --}}
    {{-- ==================================================================== --}}
    @php
        $iconMap = [
            'dashboard' => 'bi-speedometer2',
            'movies' => 'bi-film',
            'showtimes' => 'bi-clock-history',
            'bookings' => 'bi-ticket-detailed',
            'users' => 'bi-people',
        ];
    @endphp
    <x-breadcrumb :items="[['label' => ucfirst($activeTab), 'icon' => $iconMap[$activeTab] ?? 'bi-grid-1x2-fill']]" />

    @if($activeTab == 'dashboard')
    {{-- ==================================================================== --}}
    {{-- TAMPILAN UNTUK DASHBOARD STATISTIK --}}
    {{-- ==================================================================== --}}
    <div class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center mb-4">
        <h1 class="section-title mb-2 mb-lg-0">Admin Dashboard</h1>
        <div class="text-start text-lg-end">
            <small class="text-muted d-block">Waktu Server</small>
            <strong>{{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</strong>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(76, 138, 255, 0.2);">
                    <i class="bi bi-film text-primary"></i>
                </div>
                <div class="stat-value">{{ $stats['total_movies'] }}</div>
                <div class="stat-label">Total Movies</div>
                <small class="text-muted">{{ $stats['now_showing'] }} Now Showing</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(40, 167, 69, 0.2);">
                    <i class="bi bi-ticket-perforated text-success"></i>
                </div>
                <div class="stat-value">{{ $stats['confirmed_bookings'] }}</div>
                <div class="stat-label">Confirmed Bookings</div>
                <small class="text-muted">{{ $stats['total_bookings'] }} Total</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(255, 193, 7, 0.2);">
                    <i class="bi bi-cash-stack text-warning"></i>
                </div>
                <div class="stat-value" style="font-size: 1.8rem;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                <div class="stat-label">Total Revenue</div>
                <small class="text-muted">From Confirmed Bookings</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(220, 53, 69, 0.2);">
                    <i class="bi bi-people text-danger"></i>
                </div>
                <div class="stat-value">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Registered Users</div>
                <small class="text-muted">Active Members</small>
            </div>
        </div>
    </div>

    <h3 class="text-primary mb-3 mt-5"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h3>
    <div class="row g-4 mb-5">
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.dashboard', ['tab' => 'movies']) }}" class="quick-action-card">
                <div class="quick-action-icon"><i class="bi bi-film"></i></div>
                <h6 class="text-white">Manage Movies</h6>
                <small class="text-muted">Add, Edit, Delete</small>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.dashboard', ['tab' => 'showtimes']) }}" class="quick-action-card">
                <div class="quick-action-icon"><i class="bi bi-clock-history"></i></div>
                <h6 class="text-white">Manage Showtimes</h6>
                <small class="text-muted">Schedule Movies</small>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.dashboard', ['tab' => 'bookings']) }}" class="quick-action-card">
                <div class="quick-action-icon"><i class="bi bi-ticket-detailed"></i></div>
                <h6 class="text-white">View Bookings</h6>
                <small class="text-muted">All Transactions</small>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.dashboard', ['tab' => 'users']) }}" class="quick-action-card">
                <div class="quick-action-icon"><i class="bi bi-person-gear"></i></div>
                <h6 class="text-white">Manage Users</h6>
                <small class="text-muted">User Management</small>
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card movie-card">
                <div class="card-body">
                    <h5 class="text-primary mb-4"><i class="bi bi-clock-history me-2"></i>Recent Bookings</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>User</th>
                                    <th>Movie</th>
                                    <th>Show Date</th>
                                    <th>Seats</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                    <tr>
                                        <td><code>{{ $booking->booking_code }}</code></td>
                                        <td>{{ optional($booking->user)->username ?? 'User Dihapus' }}</td>
                                        <td>{{ optional(optional($booking->showtime)->movie)->title ?? 'Film Dihapus' }}</td>
                                        <td>{{ optional($booking->showtime)->show_date ? \Carbon\Carbon::parse(optional($booking->showtime)->show_date)->format('d/m/Y') : 'N/A' }}</td>
                                        <td><small>{{ $booking->seats }}</small></td>
                                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $class = match($booking->status) {
                                                    'confirmed' => 'bg-success',
                                                    'pending' => 'bg-warning',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $class }}">{{ ucfirst($booking->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No bookings yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card movie-card">
                <div class="card-body">
                    <h5 class="text-primary mb-4"><i class="bi bi-star-fill me-2"></i>Popular Movies</h5>
                    @forelse($popularMovies as $movie)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-secondary">
                            <img src="{{ asset($movie->poster_url) }}" 
                                 style="width: 50px; height: 70px; object-fit: cover; border-radius: 8px;" 
                                 alt="{{ $movie->title }}">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-1 text-white">{{ $movie->title }}</h6>
                                <small class="text-muted">{{ $movie->booking_count }} bookings</small>
                                <div class="text-warning">
                                    <small>Rp {{ number_format($movie->revenue, 0, ',', '.') }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @else
    {{-- ==================================================================== --}}
    {{-- TAMPILAN UNTUK PANEL MANAJEMEN (MOVIES, SHOWTIMES, DLL) --}}
    {{-- ==================================================================== --}}
    <div class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-start mb-4">
        <div class="mb-3 mb-lg-0">
            <h1 class="section-title mb-2">Management Panel</h1>
            <p class="text-muted">Kelola data untuk: <strong class="text-white">{{ ucfirst($activeTab) }}</strong></p> 
        </div>
        {{-- Tombol Tambah Baru --}}
        @if ($activeTab == 'movies')
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMovieModal">
            <i class="bi bi-plus-circle"></i> Tambah Film
        </a>
        @elseif ($activeTab == 'showtimes')
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShowtimeModal">
            <i class="bi bi-plus-circle"></i> Tambah Jadwal
        </a>
        @elseif ($activeTab == 'users')
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
        @endif
    </div>

    {{-- Menampilkan notifikasi sukses atau error --}}
    @if(session('success')) <div class="alert alert-success alert-dismissible fade show" role="alert"><i class="bi bi-check-circle"></i> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> @endif
    @if(session('error')) <div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="bi bi-exclamation-triangle"></i> {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> Terdapat kesalahan pada input Anda. Silakan periksa kembali.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="panel-card">
        <!-- Navigasi Tab -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'movies' ? 'active' : '' }}" href="{{ route('admin.dashboard', ['tab' => 'movies']) }}">Movies</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'showtimes' ? 'active' : '' }}" href="{{ route('admin.dashboard', ['tab' => 'showtimes']) }}">Showtimes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'bookings' ? 'active' : '' }}" href="{{ route('admin.dashboard', ['tab' => 'bookings']) }}">Bookings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'users' ? 'active' : '' }}" href="{{ route('admin.dashboard', ['tab' => 'users']) }}">Users</a>
            </li>
        </ul>

        <!-- Konten Tab -->
        <div class="tab-content">
            <div class="tab-pane fade show active">
                @switch($activeTab)
                    @case('movies')
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Poster</th>
                                        <th>Title</th>
                                        <th class="d-none d-lg-table-cell">Genre</th>
                                        <th class="d-none d-md-table-cell">Duration</th>
                                        <th class="d-none d-md-table-cell">Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($movies as $movie)
                                    <tr>
                                        <td><img src="{{ asset($movie->poster_url) }}" alt="{{ $movie->title }}" class="poster-img"></td>
                                        <td>{{ $movie->title }}</td>
                                        <td class="d-none d-lg-table-cell">{{ $movie->genre }}</td>
                                        <td class="d-none d-md-table-cell">{{ $movie->duration }} mins</td>
                                        <td class="d-none d-md-table-cell"><span class="badge {{ $movie->status == 'now_showing' ? 'bg-success' : 'bg-warning' }}">{{ ucwords(str_replace('_', ' ', $movie->status)) }}</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editMovieModal{{ $movie->id }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteMovieModal{{ $movie->id }}">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted">No movies found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $movies->links() }}
                        @break

                    @case('showtimes')
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Movie</th>
                                        <th class="d-none d-md-table-cell">Date</th>
                                        <th>Time</th>
                                        <th class="d-none d-lg-table-cell">Studio</th>
                                        <th class="d-none d-lg-table-cell">Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($showtimes as $showtime)
                                    <tr>
                                        <td>{{ $showtime->movie->title ?? 'N/A' }}</td>
                                        <td class="d-none d-md-table-cell">{{ \Carbon\Carbon::parse($showtime->show_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }}</td>
                                        <td class="d-none d-lg-table-cell">{{ $showtime->studio }}</td>
                                        <td class="d-none d-lg-table-cell">Rp {{ number_format($showtime->price, 0, ',', '.') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editShowtimeModal{{ $showtime->id }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteShowtimeModal{{ $showtime->id }}">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted">No showtimes found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $showtimes->links() }}
                        @break

                    @case('bookings')
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th class="d-none d-md-table-cell">User</th>
                                        <th>Movie</th>
                                        <th class="d-none d-lg-table-cell">Total Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bookings as $booking)
                                    <tr>
                                        <td><code>{{ $booking->booking_code }}</code></td>
                                        <td class="d-none d-md-table-cell">{{ optional($booking->user)->username ?? 'N/A' }}</td>
                                        <td>{{ optional(optional($booking->showtime)->movie)->title ?? 'N/A' }}</td>
                                        <td class="d-none d-lg-table-cell">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $class = match($booking->status) {
                                                    'confirmed' => 'bg-success',
                                                    'pending' => 'bg-warning',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $class }}">{{ ucfirst($booking->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i> Details</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted">No bookings found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $bookings->links() }}
                        @break

                    @case('users')
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th class="d-none d-lg-table-cell">Full Name</th>
                                        <th class="d-none d-md-table-cell">Joined At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="d-none d-lg-table-cell">{{ $user->full_name ?? '-' }}</td>
                                        <td class="d-none d-md-table-cell">{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $users->links() }}
                        @break
                @endswitch
            </div>
        </div>
    </div>
    @endif

    {{-- Include Modals --}}
    @if($activeTab == 'movies')
        @include('admin.movies.partials.add_modal')
        @foreach ($movies as $movie)
            @include('admin.movies.partials.edit_modal', ['movie' => $movie])
            <x-confirm-modal
                :modalId="'deleteMovieModal' . $movie->id"
                title="Hapus Film"
                :body="'Anda yakin ingin menghapus film \'' . $movie->title . '\'? Tindakan ini tidak dapat dibatalkan.'"
                confirmText="Ya, Hapus"
                cancelText="Batal"
                :confirmAction="route('admin.movies.destroy', $movie->id)"
                confirmMethod="DELETE"
                iconClass="bi-trash-fill text-danger"
                confirmButtonClass="btn-danger"
            />
        @endforeach
    @elseif($activeTab == 'showtimes')
        @include('admin.showtimes.partials.add_modal', ['allMovies' => $allMovies])
        @foreach ($showtimes as $showtime)
            @include('admin.showtimes.partials.edit_modal', ['showtime' => $showtime, 'allMovies' => $allMovies])
            <x-confirm-modal
                :modalId="'deleteShowtimeModal' . $showtime->id"
                title="Hapus Jadwal"
                :body="'Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.'"
                confirmText="Ya, Hapus"
                cancelText="Batal"
                :confirmAction="route('admin.showtimes.destroy', $showtime->id)"
                confirmMethod="DELETE"
                iconClass="bi-trash-fill text-danger"
                confirmButtonClass="btn-danger"
            />
        @endforeach
    @elseif($activeTab == 'users')
        @include('admin.users.partials.add_modal')
        @foreach ($users as $user)
            @include('admin.users.partials.edit_modal', ['user' => $user])
            <x-confirm-modal
                :modalId="'deleteUserModal' . $user->id"
                title="Hapus Pengguna"
                :body="'Anda yakin ingin menghapus pengguna \'' . $user->username . '\'? Tindakan ini tidak dapat dibatalkan.'"
                confirmText="Ya, Hapus"
                cancelText="Batal"
                :confirmAction="route('admin.users.destroy', $user->id)"
                confirmMethod="DELETE"
                iconClass="bi-person-x-fill text-danger"
                confirmButtonClass="btn-danger"
            />
        @endforeach
    @endif
</div>
@endsection