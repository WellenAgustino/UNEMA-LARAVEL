@push('styles')
<style>
    .form-control-dark {
        background: var(--medium-blue);
        border-color: var(--light-blue);
        color: var(--text-color);
    }
    .form-control-dark::placeholder {
        color: var(--text-muted);
        opacity: 1;
    }
    .form-control-dark:focus {
        background: var(--medium-blue);
        border-color: var(--primary-color-light);
        color: var(--text-color);
        box-shadow: 0 0 0 0.2rem rgba(76, 138, 255, 0.25);
    }
    .ticket-card {
        background: var(--medium-blue);
        border: 1px solid var(--light-blue);
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .ticket-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(76, 138, 255, 0.2);
    }
    .ticket-divider {
        border-top: 2px dashed var(--light-blue);
        opacity: 0.5;
        margin: 1rem 0;
    }
    .text-muted-light {
        color: var(--text-muted);
    }
    .price-highlight {
        color: #ffd700;
        font-size: 1.5rem;
    }
    .status-confirmed { background-color: rgba(40, 167, 69, 0.8); }
    .status-pending { background-color: rgba(255, 193, 7, 0.8); }
    .status-cancelled { background-color: rgba(220, 53, 69, 0.8); }

    .modal-dark {
        background-color: var(--medium-blue);
        border: 1px solid var(--light-blue);
    }
    .modal-dark .modal-header, .modal-dark .modal-footer {
        border-color: var(--light-blue);
    }
    .modal-dark .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    .ticket-card-empty {
        background: var(--medium-blue);
        border: 2px dashed var(--light-blue);
        border-radius: 15px;
    }

    /* New styles for ticket modal */
    .modal-ticket .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }
    .modal-ticket .modal-body {
        display: flex;
        padding: 0;
    }
    .ticket-main {
        padding: 1.5rem;
        flex-grow: 1;
    }
    .ticket-stub {
        padding: 1.5rem;
        background-color: rgba(0,0,0,0.1);
        border-left: 2px dashed var(--light-blue);
        writing-mode: vertical-rl;
        text-orientation: mixed;
        transform: rotate(180deg);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ticket-stub-text {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.5rem;
    }
    .pagination-container .text-muted {
        color: var(--text-muted) !important;
    }
    .pagination .page-link {
        background-color: var(--dark-blue);
        border-color: var(--light-blue);
        color: var(--text-color);
    }
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
    }
    .pagination .page-item.disabled .page-link {
        background-color: var(--medium-blue);
         border-color: var(--light-blue);
        color: #6c757d;
    }
    .pagination .page-link:hover {
        background-color: var(--medium-blue);
    }
    
    /* Tambahan Style untuk SweetAlert agar match dark theme */
    div:where(.swal2-container) div:where(.swal2-popup) {
        background: var(--medium-blue) !important;
        border: 1px solid var(--light-blue) !important;
        color: var(--text-color) !important;
    }
    div:where(.swal2-container) .swal2-title, 
    div:where(.swal2-container) .swal2-html-container {
        color: #fff !important;
    }
</style>
@endpush

<div class="container py-5">
    <h1 class="section-title mb-4">Tiket Saya</h1>

    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <input type="text" wire:model.live.debounce.300ms="searchMovie" placeholder="Cari judul film..."
                class="form-control form-control-dark">
        </div>
        <div class="col-md-3">
            <select wire:model.live="filterStatus" class="form-select form-control-dark">
                <option value="">Semua Status</option>
                <option value="confirmed">Terkonfirmasi</option>
                <option value="pending">Menunggu</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>
    </div>

    <div wire:loading.block class="w-100 text-center py-5">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Memuat...</span>
        </div>
        <h4 class="mt-3">Memuat Tiket Anda...</h4>
    </div>

    <div wire:loading.remove>
        @if ($tickets->count() > 0)
            <div class="row row-cols-1 row-cols-lg-2 g-4">
                @foreach ($tickets as $ticket)
                    <div class="col">
                        <div class="card h-100 ticket-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="me-3">
                                        <h5 class="card-title fw-bold mb-1 text-muted-light">{{ $ticket->showtime->movie->title }}</h5>
                                        <p class="mb-0 text-muted-light small">Kode Booking: <code class="text-white">{{ $ticket->booking_code }}</code></p>
                                    </div>
                                    <span class="badge rounded-pill fs-6 {{ $this->getStatusClass($ticket->status) }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </div>

                                <hr class="ticket-divider">

                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <p class="mb-1 small text-muted-light"><i class="bi bi-calendar-event me-2"></i>Tanggal</p>
                                        <h6 class="mb-0 fw-bold text-white">{{ \Carbon\Carbon::parse($ticket->showtime->show_date)->format('d M Y') }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-1 small text-muted-light"><i class="bi bi-clock me-2"></i>Jam Tayang</p>
                                        <h6 class="mb-0 fw-bold text-white">{{ \Carbon\Carbon::parse($ticket->showtime->show_time)->format('H:i') }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-1 small text-muted-light"><i class="bi bi-building me-2"></i>Studio</p>
                                        <h6 class="mb-0 fw-bold text-white">{{ $ticket->showtime->studio }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-1 small text-muted-light"><i class="bi bi-chair-recline me-2"></i>Kursi</p>
                                        <h6 class="mb-0 fw-bold text-white">{{ $ticket->seats }}</h6>
                                    </div>
                                </div>

                                <hr class="ticket-divider">

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 text-muted-light">Total Harga</p>
                                        <p class="fw-bold price-highlight mb-0">Rp {{ number_format($ticket->total_price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $ticket->id }}">
                                            <i class="bi bi-eye"></i> Rincian
                                        </button>
                                        @if ($ticket->status === 'confirmed')
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="confirmCancellation({{ $ticket->id }})">
                                                <i class="bi bi-x-circle"></i> Batalkan
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade modal-ticket" id="detailModal{{ $ticket->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $ticket->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content modal-dark">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel{{ $ticket->id }}">Rincian Tiket</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <div class="ticket-main">
                                        <div class="mb-4">
                                            <p class="mb-1 small text-muted-light">Film</p>
                                            <h5 class="fw-bold text-white">{{ $ticket->showtime->movie->title }}</h5>
                                            <p class="mb-0 text-muted-light small">Kode Booking: <code class="text-white">{{ $ticket->booking_code }}</code></p>
                                        </div>

                                        <hr class="ticket-divider">

                                        <div class="row g-4 my-2">
                                            <div class="col-6"><p class="mb-1 small text-muted-light"><i class="bi bi-calendar-event me-2"></i>Tanggal</p><h6 class="mb-0 fw-bold text-white">{{ \Carbon\Carbon::parse($ticket->showtime->show_date)->format('d M Y') }}</h6></div>
                                            <div class="col-6"><p class="mb-1 small text-muted-light"><i class="bi bi-clock me-2"></i>Waktu</p><h6 class="mb-0 fw-bold text-white">{{ \Carbon\Carbon::parse($ticket->showtime->show_time)->format('H:i') }}</h6></div>
                                            <div class="col-6"><p class="mb-1 small text-muted-light"><i class="bi bi-building me-2"></i>Studio</p><h6 class="mb-0 fw-bold text-white">{{ $ticket->showtime->studio }}</h6></div>
                                            <div class="col-6"><p class="mb-1 small text-muted-light"><i class="bi bi-chair-recline me-2"></i>Kursi</p><h6 class="mb-0 fw-bold text-white">{{ $ticket->seats }}</h6></div>
                                        </div>

                                        <hr class="ticket-divider">

                                        <p><strong>Total Harga:</strong> <span class="price-highlight">Rp {{ number_format($ticket->total_price, 0, ',', '.') }}</span></p>
                                        <p><strong>Status:</strong> <span class="badge rounded-pill fs-6 {{ $this->getStatusClass($ticket->status) }}">{{ ucfirst($ticket->status) }}</span></p>
                                    </div>
                                    <div class="ticket-stub">
                                        <span class="ticket-stub-text">UNEMA CINEMA</span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5 pagination-container">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="text-center p-5 card ticket-card-empty">
                <i class="bi bi-ticket-perforated" style="font-size: 4rem; color: var(--light-blue);"></i>
                <h4 class="mt-3 text-white">Tidak Ada Tiket Ditemukan</h4>
                <p class="text-muted-light">
                    @if(empty($searchMovie) && empty($filterStatus))
                        Anda belum memiliki tiket. Ayo pesan sekarang!
                    @else
                        Tidak ada tiket yang cocok dengan filter pencarian Anda.
                    @endif
                </p>
                <div class="mt-3">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bi bi-film"></i> Cari Film
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmCancellation(ticketId) {
        Swal.fire({
            title: 'Batalkan Tiket?',
            text: "Anda yakin ingin membatalkan tiket ini? Tindakan ini tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Kembali',
            // Styling manual untuk fallback, CSS class menangani sisanya
            background: 'var(--medium-blue)', 
            color: '#fff' 
        }).then((result) => {
            if (result.isConfirmed) {
                // Panggil method Livewire 'cancelTicket' dengan ID
                @this.call('cancelTicket', ticketId);
                
                // Opsional: Tampilkan loading atau pesan singkat
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar.',
                    icon: 'info',
                    showConfirmButton: false,
                    timer: 1500,
                    background: 'var(--medium-blue)',
                    color: '#fff'
                });
            }
        })
    }
</script>
@endpush