<?php

use App\Http\Controllers\AdminMovieController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminShowtimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/showtimes', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::get('/showtimes/{movieId}', [ShowtimeController::class, 'getShowtimes']);

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard'); // Rute ini sekarang menangani dashboard & manajemen
    // Rute untuk Manajemen Film (CRUD)
    Route::post('movies', [AdminMovieController::class, 'store'])->name('movies.store');
    Route::put('movies/{movie}', [AdminMovieController::class, 'update'])->name('movies.update');
    Route::delete('movies/{movie}', [AdminMovieController::class, 'destroy'])->name('movies.destroy');
    // Rute untuk Manajemen Jadwal (CRUD)
    Route::post('showtimes', [AdminShowtimeController::class, 'store'])->name('showtimes.store');
    Route::put('showtimes/{showtime}', [AdminShowtimeController::class, 'update'])->name('showtimes.update');
    Route::delete('showtimes/{showtime}', [AdminShowtimeController::class, 'destroy'])->name('showtimes.destroy');
    // Rute untuk Manajemen Booking
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
    // Rute untuk Manajemen User (CRUD)
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

// Settings Route
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update']);
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Booking Routes
    Route::get('/select-seats/{showtimeId}', [BookingController::class, 'selectSeats'])->name('select-seats');
    Route::post('/validate-checkout', [BookingController::class, 'validateCheckout'])->name('validate-checkout');
    Route::post('/checkout', [BookingController::class, 'checkout'])->name('checkout');
    Route::post('/process-payment', [BookingController::class, 'processPayment'])->name('process-payment');
    Route::post('/booking/confirm-payment', [BookingController::class, 'confirmPayment'])->name('booking.confirm-payment');
    Route::get('/booking-success', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/booking/{bookingId}/status', [BookingController::class, 'checkStatus'])->name('booking.check-status');

    // Ticket Routes
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tickets/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');
});

// Payment Callback (Public)
Route::post('/payment-callback', [BookingController::class, 'paymentCallback'])->name('payment.callback');
