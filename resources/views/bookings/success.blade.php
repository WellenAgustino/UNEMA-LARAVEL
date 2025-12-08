@extends('layouts.app')

@section('title', 'Status Pembayaran - UNEMA Cinema')

@section('content')
{{-- Optional: Add this style block if you want specific tweaks, otherwise rely on your app.css --}}
<style>
    /* Ensure the variables exist or fallback to standard colors */
    :root {
        --medium-blue: #1a2236; /* Example dark blue */
        --dark-blue: #0f1523;   /* Example darker blue */
        --light-blue: #2c3e50;  /* Border color */
    }

    .status-card {
        background: var(--medium-blue, #1a2236);
        border: 1px solid var(--light-blue, #2c3e50);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .detail-row {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .success-icon-glow {
        text-shadow: 0 0 20px rgba(25, 135, 84, 0.4);
        animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div id="status-container">
                @if($booking->status === 'confirmed')
                    <div class="card status-card rounded-4 text-white">
                        <div class="card-body text-center p-4 p-md-5">
                            <div class="mb-4 success-icon-glow">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                            </div>

                            <h2 class="fw-bold mb-2">Pembayaran Berhasil!</h2>
                            <p class="text-white-50 mb-4">Terima kasih, tiket Anda sudah terbit.</p>

                            <div class="bg-dark bg-opacity-25 rounded-3 p-4 mb-4 text-start">
                                <h6 class="text-uppercase text-white-50 fw-bold small mb-3 ls-1">Detail Booking</h6>

                                <div class="detail-row d-flex justify-content-between align-items-center">
                                    <span class="text-white-50">Kode Booking</span>
                                    <span class="fw-bold font-monospace fs-5 text-warning">{{ $booking->booking_code }}</span>
                                </div>

                                <div class="detail-row d-flex justify-content-between">
                                    <span class="text-white-50">Film</span>
                                    <span class="text-end fw-semibold">{{ $booking->showtime->movie->title }}</span>
                                </div>

                                <div class="detail-row d-flex justify-content-between">
                                    <span class="text-white-50">Kursi</span>
                                    <span class="text-end fw-semibold">{{ $booking->seats }}</span>
                                </div>

                                <div class="detail-row d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-secondary">
                                    <span class="text-white-50">Total</span>
                                    <span class="fw-bold fs-5 text-success">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('tickets.index') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                    <i class="bi bi-ticket-perforated me-2"></i> Lihat Tiket Saya
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm rounded-pill mt-2 border-0">
                                    <i class="bi bi-house me-1"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card status-card rounded-4 text-white">
                        <div class="card-body text-center p-4 p-md-5">
                            <div class="mb-4 mt-3">
                                <div class="spinner-border text-warning" role="status" style="width: 4rem; height: 4rem; border-width: 4px;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <h3 class="fw-bold mb-2">Memproses Pembayaran</h3>
                            <p class="text-white-50 mb-4">Mohon jangan tutup halaman ini...</p>

                            <div class="bg-dark bg-opacity-25 rounded-3 p-3 mb-4">
                                <p class="mb-1 text-white-50 small">Kode Booking</p>
                                <p class="h4 mb-0 font-monospace">{{ $booking->booking_code }}</p>
                            </div>

                            <p class="small text-muted fst-italic">
                                <i class="bi bi-shield-lock me-1"></i> Menunggu konfirmasi bank...
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Payment Status Polling Logic --}}
<script>
@if($booking->status !== 'confirmed')
    let checkCount = 0;
    const maxChecks = 60; // Check untuk max 2 menit
    const bookingId = '{{ $booking->id }}';
    const checkUrl = '{{ route("booking.check-status", ["bookingId" => $booking->id]) }}';
    const homeUrl = '{{ route("home") }}';
    const ticketsUrl = '{{ route("tickets.index") }}';

    console.log(`Starting payment status check for booking ID: ${bookingId}`);
    console.log(`Current booking status: {{ $booking->status }}`);

    // Wait 3 seconds sebelum mulai polling (beri waktu callback dari Midtrans)
    setTimeout(function() {
        console.log('Starting polling after 3 second delay...');
        
        const checkInterval = setInterval(function() {
            checkCount++;
            console.log(`Poll attempt ${checkCount}/${maxChecks}...`);

            fetch(checkUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(`Attempt ${checkCount}: Status = ${data.status}`);

                    if (data.status === 'confirmed') {
                        console.log('✅ Payment confirmed! Reloading page...');
                        clearInterval(checkInterval);
                        // Delay 1 second sebelum reload untuk visual feedback
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    else if (data.status === 'cancelled') {
                        console.log('❌ Payment cancelled/failed');
                        clearInterval(checkInterval);
                        alert('Pembayaran dibatalkan atau gagal.');
                        window.location.href = homeUrl;
                    }

                    // Stop checking after max attempts
                    if (checkCount >= maxChecks) {
                        console.log('Max polling attempts reached');
                        clearInterval(checkInterval);
                        alert('Status pembayaran masih pending. Silakan cek tiket Anda nanti atau hubungi customer service.');
                        window.location.href = ticketsUrl;
                    }
                })
                .catch(error => {
                    console.error('Error checking status:', error);
                    if (checkCount >= maxChecks) {
                        clearInterval(checkInterval);
                    }
                });
        }, 2000); // Poll setiap 2 detik
    }, 3000); // Initial delay 3 detik
@endif
</script>
@endsection
