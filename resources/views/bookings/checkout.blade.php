@extends('layouts.app')

@section('title', 'Checkout - UNEMA Cinema')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="section-title mb-4">Konfirmasi Pemesanan</h1>

            <div class="card mb-4" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
                <div class="card-body">
                    <h5 class="card-title" style="color: #a0b0c0;">Detail film</h5>
                    <hr style="border-color: var(--light-blue);">

                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ $showtime->movie->poster_url }}" alt="{{ $showtime->movie->title }}" style="width: 100%; border-radius: 10px;">
                        </div>
                        <div class="col-md-9" style="color: var(--text-muted);">
                            <h4 class="fw-bold">{{ $showtime->movie->title }}</h6>
                            <h6 class="mb-1"><strong>Tanggal:</strong> {{ $showtime->show_date->format('d M Y') }}</h6>
                            <h6 class="mb-1"><strong>Jam:</strong> {{ $showtime->show_time }}</h6>
                            <h6 class="mb-1 "><strong>Studio:</strong> {{ $showtime->studio }}</h6>
                            <h6 class="mb-1"><strong>Kursi:</strong> {{ implode(', ', $seats) }}</h6>
                            <h6 class="mb-0"><strong>Jumlah Tiket:</strong> {{ count($seats) }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
                <div class="card-body">
                    <h5 class="card-title" style="color: #a0b0c0;">Metode Pembayaran</h5>

                    <hr style="border-color: var(--light-blue);">

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Anda akan diarahkan ke halaman pembayaran Midtrans untuk menyelesaikan transaksi.
                    </div>

                    <button type="button" class="btn btn-primary btn-lg w-100" id="payBtn">
                        <i class="bi bi-credit-card"></i> Lanjut ke Pembayaran
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card sticky-top" style="background: var(--medium-blue); border: 1px solid var(--light-blue); top: 20px;">
                <div class="card-body">
                    <h5 class="card-title" style="color: var(--text-muted);">Ringkasan Pembayaran</h5>
                    <hr style="border-color: var(--light-blue);">

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: var(--text-muted);">Harga per Tiket:</span>
                            <span style="color: var(--text-muted);">Rp {{ number_format($showtime->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: var(--text-muted);">Jumlah Tiket:</span>
                            <span style="color: var(--text-muted);">{{ count($seats) }}</span>
                        </div>
                    </div>

                    <hr style="border-color: var(--light-blue);">

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span style="color: var(--text-muted);">Total:</span>
                            <span style="font-size: 1.5rem; color: #ffd700; font-weight: bold;">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <hr style="border-color: var(--light-blue);">

                    <div class="mb-3">
                        <p class="mb-1" style="color: var(--text-muted); font-size: 0.9rem;">Kode Booking:</p>
                        <p class="fw-bold" style="font-size: 1.1rem; color: #6c757d;">{{ $booking->booking_code }}</p>

                    </div>

                    <a href="{{ route('showtimes.index') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}">
</script>

<script>
    document.getElementById('payBtn').addEventListener('click', function() {
        const payButton = this;

        // 1. Disable tombol & ubah text loading agar tidak diklik 2x
        payButton.disabled = true;
        payButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';

        fetch('{{ route("process-payment") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: {{ $booking->id }}
            })
        })
        .then(response => response.json())
        .then(data => {
            // Kembalikan tombol ke semula jika snap token didapat
            payButton.disabled = false;
            payButton.innerHTML = '<i class="bi bi-credit-card"></i> Lanjut ke Pembayaran';

            if (data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        // Log success result dari Midtrans
                        console.log('Payment success result:', result);
                        
                        // Optional: Trigger server-side verification/update
                        // Sebelum redirect ke success page
                        fetch('{{ route("booking.confirm-payment") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                booking_id: {{ $booking->id }},
                                transaction_id: result.transaction_id
                            })
                        })
                        .then(() => {
                            // Redirect dengan membawa booking_id agar aman
                            window.location.href = '{{ route("booking.success") }}?booking_id={{ $booking->id }}';
                        })
                        .catch(() => {
                            // Jika confirm gagal, tetap redirect
                            window.location.href = '{{ route("booking.success") }}?booking_id={{ $booking->id }}';
                        });
                    },
                    onPending: function(result) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Pembayaran Tertunda',
                            text: 'Silakan selesaikan pembayaran Anda. Status tiket akan diperbarui otomatis.',
                            confirmButtonText: 'Cek Status',
                            allowOutsideClick: false
                        }).then(() => {
                            // Redirect ke success page juga aman, karena di sana statusnya 'pending'
                            window.location.href = '{{ route("booking.success") }}?booking_id={{ $booking->id }}';
                        });
                    },
                    onError: function(result) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Pembayaran Gagal',
                            text: 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.'
                        });
                    },
                    onClose: function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pembayaran Belum Selesai',
                            text: 'Anda menutup jendela pembayaran sebelum transaksi selesai.'
                        });
                    }
                });
            } else {
                Swal.fire('Error', 'Gagal mendapatkan token pembayaran', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            payButton.disabled = false;
            payButton.innerHTML = '<i class="bi bi-credit-card"></i> Lanjut ke Pembayaran';
            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
        });
    });
</script>
@endsection