@extends('layouts.app')

@section('title', 'Pilih Kursi - UNEMA Cinema')

@section('content')
<div class="container-fluid px-3 px-md-5 py-4 py-md-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="section-title mb-4">Pilih Kursi</h1>
            
            <div class="card mb-4 bg-dark">
                <div class="card-body text-light">
                    <h5 class="card-title">{{ $showtime->movie->title }}</h5>
                    <p class="mb-0 small-md-normal"> <span class="d-block d-md-inline mb-1 mb-md-0"><i class="bi bi-calendar-event"></i> {{ $showtime->show_date->format('d M Y') }} &nbsp;|&nbsp;</span>
                        <span class="d-block d-md-inline mb-1 mb-md-0"><i class="bi bi-clock"></i> {{ $showtime->show_time }} &nbsp;|&nbsp;</span>
                        <span class="d-block d-md-inline"><i class="bi bi-building"></i>  {{ $showtime->studio }}</span>
                    </p>
                </div>
            </div>

            <div class="text-center mb-4">
                
                <form id="seatForm" method="POST" action="{{ route('checkout') }}">
                    @csrf
                    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                    
                    <!-- 🔐 FIX #3: Error display untuk validation errors -->
                    <div id="validationError" class="alert alert-danger d-none mb-4" style="margin-top: 1rem;">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>Validasi Gagal!</strong>
                        <p id="errorMessage" class="mb-0 mt-2"></p>
                    </div>
                    
                    <div class="seat-scroll-container mb-4 text-center">
                        <div class="d-inline-block"> <div class="screen-indicator mb-4">
                                <p style="margin: 0; color: var(--text-muted); font-weight:bold; letter-spacing: 2px;">LAYAR</p>
                            </div>

                            <div class="seat-grid text-start" style="display: inline-block;">
                                @php
                                    $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                                    $cols = 10;
                                @endphp

                                @foreach($rows as $row)
                                    <div class="d-flex align-items-center mb-2 flex-nowrap gap-2">
                                        <span class="row-label">{{ $row }}</span>
                                        @for($col = 1; $col <= $cols; $col++)
                                            @php
                                                $seatId = $row . $col;
                                                $isBooked = in_array($seatId, $bookedSeatsArray);
                                            @endphp
                                            <label class="seat-wrapper" style="cursor: {{ $isBooked ? 'not-allowed' : 'pointer' }};">
                                                <input 
                                                    type="checkbox" 
                                                    name="seats[]" 
                                                    value="{{ $seatId }}"
                                                    {{ $isBooked ? 'disabled' : '' }}
                                                    class="seat-checkbox d-none"
                                                >
                                                <div class="seat {{ $isBooked ? 'booked' : '' }}">
                                                    {{ $col }}
                                                </div>
                                            </label>
                                        @endfor
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <div class="seat-legend available"></div>
                                <span class="small">Tersedia</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="seat-legend selected"></div>
                                <span class="small">Dipilih</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="seat-legend booked"></div>
                                <span class="small">Terjual</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center d-none d-lg-block"> <button type="button" class="btn btn-primary btn-lg w-50" id="checkoutBtnDesktop" disabled>
                            <i class="bi bi-hourglass-split"></i> <span id="desktopBtnText">Lanjut ke Pembayaran</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card sticky-top" style="background: var(--medium-blue); border: 1px solid var(--light-blue); top: 20px; z-index: 10;">
                <div class="card-body">
                    <h5 class="text-white">Ringkasan Pemesanan</h5>
                    <hr style="border-color: var(--light-blue);">
                    
                    <div class="mb-3">
                        <p class="mb-1" style="color: var(--text-muted);">Kursi Dipilih:</p>
                        <p class="text-warning fw-bold" id="selectedSeats">Belum ada kursi dipilih</p>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1" style="color: var(--text-muted);">Harga per Kursi:</p>
                        <p class="text-primary">Rp {{ number_format($showtime->price, 0, ',', '.') }}</p>
                    </div>

                    <hr style="border-color: var(--light-blue);">

                    <div class="mb-3">
                        <p class="mb-1" style="color: var(--text-muted);">Total Harga:</p>
                        <p class="text-danger fw-bold" style="font-size: 1.5rem; color: #ffd700 !important;" id="totalPrice">Rp 0</p>
                    </div>
                    
                    <div class="d-block d-lg-none mt-3">
                         <button type="button" class="btn btn-primary w-100 py-3" id="checkoutBtnMobile" onclick="return false;" disabled>
                            <i class="bi bi-hourglass-split"></i> <span id="mobileBtnText">Lanjut Bayar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Responsive Scroll Container */
    .seat-scroll-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scroll on iOS */
        padding-bottom: 1rem;
        width: 100%;
    }

    /* Screen Indicator Styling */
    .screen-indicator {
        background: var(--light-blue);
        padding: 0.5rem;
        border-radius: 5px 5px 50% 50%; /* Efek melengkung sedikit */
        width: 100%;
        min-width: 300px; /* Minimal width agar tidak terlalu kecil */
        box-shadow: 0 10px 15px -10px rgba(76, 138, 255, 0.5);
    }

    /* Row Label (A, B, C) */
    .row-label {
        width: 25px;
        text-align: right; 
        color: var(--text-muted);
        font-weight: bold;
        flex-shrink: 0; /* Mencegah label mengecil */
    }

    /* Seat Base Style */
    .seat {
        width: 35px; /* Sedikit dikecilkan untuk mobile, tapi tetap nyaman */
        height: 35px;
        border: 2px solid var(--light-blue);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        background: var(--medium-blue);
        color: var(--text-muted);
        transition: all 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Desktop size adjustment */
    @media (min-width: 768px) {
        .seat {
            width: 40px;
            height: 40px;
        }
        .row-label {
            width: 30px;
        }
    }

    /* Interactive States */
    .seat:hover {
        border-color: var(--primary-color);
        transform: scale(1.1);
    }

    /* Checked State */
    input[type="checkbox"]:checked + .seat {
        background: var(--primary-color-light) !important;
        border-color: var(--primary-color-light) !important;
        color: white !important;
        box-shadow: 0 0 10px rgba(76, 138, 255, 0.5);
    }

    /* Booked State */
    .seat.booked {
        background: #2c3036 !important;
        border-color: #444 !important;
        color: #555 !important;
        cursor: not-allowed;
    }
    .seat.booked:hover {
        transform: none;
        border-color: #444;
    }

    /* Legend Squares */
    .seat-legend {
        width: 25px;
        height: 25px;
        border-radius: 4px;
    }
    .seat-legend.available {
        border: 2px solid var(--light-blue);
        background: var(--medium-blue);
    }
    .seat-legend.selected {
        border: 2px solid var(--primary-color-light);
        background: var(--primary-color-light);
    }
    .seat-legend.booked {
        border: 2px solid #444;
        background: #2c3036;
    }
</style>
@endpush

<script>
    const pricePerSeat = {{ $showtime->price }};
    const checkboxes = document.querySelectorAll('.seat-checkbox');
    const selectedSeatsDisplay = document.getElementById('selectedSeats');
    const totalPriceDisplay = document.getElementById('totalPrice');
    const checkoutBtnDesktop = document.getElementById('checkoutBtnDesktop');
    const checkoutBtnMobile = document.getElementById('checkoutBtnMobile');
    const validationError = document.getElementById('validationError');
    const errorMessage = document.getElementById('errorMessage');

    function updateSummary() {
        const selectedSeats = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (selectedSeats.length > 0) {
            selectedSeatsDisplay.textContent = selectedSeats.join(', ');
            const totalPrice = selectedSeats.length * pricePerSeat;
            const formattedPrice = 'Rp ' + totalPrice.toLocaleString('id-ID');
            
            totalPriceDisplay.textContent = formattedPrice;
            
            checkoutBtnDesktop.disabled = false;
            checkoutBtnMobile.disabled = false;
        } else {
            selectedSeatsDisplay.textContent = 'Belum ada kursi dipilih';
            totalPriceDisplay.textContent = 'Rp 0';
            
            checkoutBtnDesktop.disabled = true;
            checkoutBtnMobile.disabled = true;
        }
    }

    // 🔐 FIX #3: AJAX validation sebelum form submit
    async function validateAndCheckout(e) {
        e.preventDefault();

        const selectedSeats = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (selectedSeats.length === 0) {
            showValidationError('Pilih minimal 1 kursi sebelum melanjutkan');
            return;
        }

        // Set button loading state
        checkoutBtnDesktop.disabled = true;
        checkoutBtnMobile.disabled = true;
        document.getElementById('desktopBtnText').textContent = 'Memvalidasi...';
        document.getElementById('mobileBtnText').textContent = 'Memvalidasi...';

        try {
            // Pre-flight validation via AJAX
            const response = await fetch('{{ route("validate-checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    showtime_id: {{ $showtime->id }},
                    seats: selectedSeats
                })
            });

            const data = await response.json();

            if (!data.valid) {
                showValidationError(data.message || 'Kursi tidak tersedia');
                checkoutBtnDesktop.disabled = false;
                checkoutBtnMobile.disabled = false;
                document.getElementById('desktopBtnText').textContent = 'Lanjut ke Pembayaran';
                document.getElementById('mobileBtnText').textContent = 'Lanjut Bayar';
                return;
            }

            // Valid, submit form
            document.getElementById('seatForm').submit();

        } catch (error) {
            console.error('Validation error:', error);
            showValidationError('Terjadi kesalahan saat validasi. Silakan coba lagi.');
            checkoutBtnDesktop.disabled = false;
            checkoutBtnMobile.disabled = false;
            document.getElementById('desktopBtnText').textContent = 'Lanjut ke Pembayaran';
            document.getElementById('mobileBtnText').textContent = 'Lanjut Bayar';
        }
    }

    function showValidationError(message) {
        errorMessage.textContent = message;
        validationError.classList.remove('d-none');
        
        // Scroll ke error message
        validationError.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function hideValidationError() {
        validationError.classList.add('d-none');
        errorMessage.textContent = '';
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            updateSummary();
            hideValidationError();  // Clear error saat user select kursi lagi
        });
    });

    // Attach validation to buttons
    checkoutBtnDesktop.addEventListener('click', validateAndCheckout);
    checkoutBtnMobile.addEventListener('click', validateAndCheckout);

    updateSummary();
</script>
@endsection