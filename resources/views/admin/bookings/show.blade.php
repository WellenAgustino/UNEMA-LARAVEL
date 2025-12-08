@extends('layouts.app')

@section('title', 'Detail Pemesanan - UNEMA Cinema')

@push('styles')
{{-- 1. SweetAlert2 Dark Theme CSS --}}
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

<style>
    /* Styling Panel Card agar sesuai tema Dark Mode */
    .panel-card {
        background-color: var(--medium-blue, #161B29); /* Fallback color jika var tidak ada */
        border: 1px solid var(--light-blue, #373b3e);
        border-radius: 0.5rem;
        color: #fff;
    }
    
    .modal-content.panel-card {
        background-color: var(--medium-blue, #161B29);
        color: #fff;
    }

    /* Mengubah warna border hr agar tidak terlalu terang */
    hr {
        border-top: 1px solid #495057;
        opacity: 0.5;
    }

    /* Perbaikan visual link */
    a.text-decoration-none:hover {
        text-decoration: underline !important;
    }
</style>
@endpush

@section('content')
{{-- 2. SweetAlert2 JS Library --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<div class="container-fluid px-3 px-lg-5 py-4">
    <h1 class="section-title mb-4 text-white">Detail Pemesanan</h1>

    {{-- Breadcrumb Component --}}
    {{-- Pastikan file components/breadcrumb.blade.php sudah menggunakan kode responsive terbaru --}}
    <x-breadcrumb :items="[
        ['label' => 'Bookings', 'url' => route('admin.dashboard', ['tab' => 'bookings'])],
        ['label' => 'Detail', 'icon' => 'bi-ticket-detailed']
    ]" />

    {{-- Notifikasi Session --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- KOLOM KIRI (Detail Booking & Film) --}}
        <div class="col-lg-8">
            
            {{-- 1. Panel Detail Pemesanan --}}
            <div class="panel-card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div>
                            <h5 class="card-title text-primary mb-1"><i class="bi bi-ticket-perforated me-2"></i>Info Transaksi</h5>
                            <p class="text-white-50 small mb-0">Dipesan pada: {{ $booking->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="text-end">
                            @php
                                $statusClass = match($booking->status) {
                                    'confirmed' => 'bg-success',
                                    'pending' => 'bg-warning text-dark',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <p class="fw-bold font-monospace mb-1 fs-5"><code>{{ $booking->booking_code }}</code></p>
                            <span id="booking-status-badge" class="badge {{ $statusClass }} fs-6">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                    <hr>
                    <dl class="row mb-0">
                        <dt class="col-sm-3 text-white-50">Jumlah Kursi</dt>
                        <dd class="col-sm-9 fw-bold">{{ count(explode(',', $booking->seats)) }} kursi</dd>

                        <dt class="col-sm-3 text-white-50">Total Harga</dt>
                        <dd class="col-sm-9 fw-bold fs-5 text-warning">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>

            {{-- 2. Panel Detail Film & Jadwal (DENGAN FIX NULL SAFETY) --}}
            <div class="panel-card">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-film me-2"></i>Informasi Film & Jadwal</h5>
                    <hr>

                    {{-- CEK: Apakah data Showtime dan Movie masih ada? --}}
                    @if($booking->showtime && $booking->showtime->movie)
                        <div class="d-flex flex-column flex-sm-row">
                            {{-- Poster --}}
                            <div class="flex-shrink-0 mb-3 mb-sm-0 text-center text-sm-start">
                                <img src="{{ asset($booking->showtime->movie->poster_url) }}" 
                                     class="img-fluid rounded shadow-sm" 
                                     style="width: 120px; height: 180px; object-fit: cover;" 
                                     alt="Poster">
                            </div>
                            
                            {{-- Info Text --}}
                            <div class="ms-sm-4 flex-grow-1">
                                <h4 class="mb-1 text-white">{{ $booking->showtime->movie->title }}</h4>
                                <p class="text-white-50 mb-3">
                                    {{ $booking->showtime->movie->genre }} | {{ $booking->showtime->movie->duration }} menit
                                </p>

                                <div class="row g-0">
                                    <div class="col-md-6 mb-2">
                                        <small class="text-white-50 d-block">Tanggal & Jam</small>
                                        <span class="text-white">
                                            <i class="bi bi-calendar3 me-1"></i> {{ $booking->showtime->show_date->format('d M Y') }} <br>
                                            <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($booking->showtime->show_time)->format('H:i') }} WIB
                                        </span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-white-50 d-block">Studio & Kursi</small>
                                        <span class="text-white d-block">{{ $booking->showtime->studio }}</span>
                                        <span class="text-warning fw-bold"><i class="bi bi-grid-3x3 me-1"></i> {{ $booking->seats }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- TAMPILAN JIKA DATA DIHAPUS --}}
                        <div class="alert alert-secondary d-flex align-items-center mb-0" role="alert" style="background: rgba(108, 117, 125, 0.2); border-color: #6c757d;">
                            <i class="bi bi-exclamation-triangle-fill fs-2 me-3 text-warning"></i>
                            <div>
                                <h6 class="alert-heading fw-bold mb-1">Data Film Tidak Ditemukan</h6>
                                <p class="mb-0 small">Jadwal atau Film terkait pemesanan ini telah dihapus dari database.</p>
                                <hr class="my-2">
                                <small class="text-white-50">Kursi yang dipesan: <strong>{{ $booking->seats }}</strong></small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN (User & Actions) --}}
        <div class="col-lg-4">
            
            {{-- 3. Panel Detail Pelanggan --}}
            <div class="panel-card mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-person-circle me-2"></i>Detail Pelanggan</h5>
                    <hr>
                    @if($booking->user)
                        <dl class="mb-0">
                            <dt class="text-white-50 small">Nama Pengguna</dt>
                            <dd class="fw-bold fs-5 mb-3">
                                <a href="{{ route('admin.dashboard', ['tab' => 'users', 'search' => $booking->user->username]) }}" class="text-white text-decoration-none" title="Lihat profil">
                                    {{ $booking->user->username }} <i class="bi bi-box-arrow-up-right small ms-1 text-muted"></i>
                                </a>
                            </dd>

                            <dt class="text-white-50 small">Email</dt>
                            <dd class="text-white mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-envelope me-2 text-muted"></i>
                                    <span class="text-break">{{ $booking->user->email }}</span>
                                </div>
                            </dd>

                            <dt class="text-white-50 small">Nomor Telepon</dt>
                            <dd class="text-white mb-0">
                                <i class="bi bi-telephone me-2 text-muted"></i>{{ $booking->user->phone ?? '-' }}
                            </dd>
                        </dl>
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-person-x fs-1"></i>
                            <p class="mb-0">Pengguna telah dihapus.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 4. Panel Aksi --}}
            <div class="panel-card">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-gear me-2"></i>Aksi</h5>
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.dashboard', ['tab' => 'bookings']) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>

                        {{-- Tombol Approve (Hanya jika pending) --}}
                        @if($booking->status === 'pending')
                        <button type="button" id="approve-trigger-btn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveConfirmationModal">
                            <i class="bi bi-check-circle me-2"></i>Konfirmasi Pesanan
                        </button>
                        @endif

                        {{-- Tombol Batalkan --}}
                        @if($booking->status === 'pending' || $booking->status === 'confirmed')
                        <form id="form-cancel" action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning w-100">
                                <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
                            </button>
                        </form>
                        @endif

                        {{-- Tombol Hapus --}}
                        <form id="form-delete" action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash me-2"></i>Hapus Permanen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Konfirmasi Approve --}}
@if ($booking->status === 'pending')
<div class="modal fade" id="approveConfirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content panel-card">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title text-success"><i class="bi bi-check-circle-fill me-2"></i>Konfirmasi Pesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-white">Anda akan mengkonfirmasi pesanan <strong>{{ $booking->booking_code }}</strong>.</p>
<div class="alert alert-dark border-secondary mb-0" style="background: rgba(255, 255, 255, 0.05);">
    <small class="text-white-50">
        <i class="bi bi-info-circle me-1"></i> 
        Status akan berubah menjadi <span class="text-success fw-bold">Confirmed</span>.
    </small>
</div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirm-approve-btn" class="btn btn-success">Ya, Konfirmasi</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // --- Config Toast ---
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#161B29', // Dark background for toast
        color: '#fff',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // --- 1. LOGIKA APPROVE (AJAX) ---
    const confirmApproveBtn = document.getElementById('confirm-approve-btn');
    const approveModalEl = document.getElementById('approveConfirmationModal');

    if (confirmApproveBtn && approveModalEl) {
        const approveModal = new bootstrap.Modal(approveModalEl);

        confirmApproveBtn.addEventListener('click', function() {
            const url = `{{ route('admin.bookings.approve', $booking->id) }}`;
            const csrfToken = '{{ csrf_token() }}';

            // UI Loading
            const originalText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';

            fetch(url, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': csrfToken, 
                    'Accept': 'application/json' 
                }
            })
            .then(response => response.json().then(data => ({ ok: response.ok, data })))
            .then(({ ok, data }) => {
                approveModal.hide();

                if (ok) {
                    // Update UI tanpa reload
                    const statusBadge = document.getElementById('booking-status-badge');
                    if(statusBadge) {
                        statusBadge.textContent = 'Confirmed';
                        statusBadge.className = 'badge bg-success fs-6';
                    }
                    const approveTriggerBtn = document.getElementById('approve-trigger-btn');
                    if (approveTriggerBtn) approveTriggerBtn.remove(); // Hapus tombol approve

                    Toast.fire({ icon: 'success', title: data.message });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                }
            })
            .catch(error => {
                approveModal.hide();
                console.error(error);
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan sistem.' });
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = originalText;
            });
        });
    }

    // --- 2. LOGIKA CANCEL & DELETE (Confirmation) ---
    const handleFormSubmit = (formId, title, text, icon, confirmBtnText, confirmBtnColor) => {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: 'Batal',
                    confirmButtonColor: confirmBtnColor,
                    cancelButtonColor: '#6c757d',
                    background: '#161B29', // Dark background
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) this.submit();
                });
            });
        }
    };

    handleFormSubmit('form-cancel', 'Batalkan Pesanan?', "Status akan berubah menjadi 'Cancelled'.", 'warning', 'Ya, Batalkan', '#ffc107');
    handleFormSubmit('form-delete', 'Hapus Permanen?', "Data tidak dapat dikembalikan!", 'error', 'Ya, Hapus', '#dc3545');

});
</script>
@endpush