<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function selectSeats($showtimeId)
    {
        $showtime = Showtime::with('movie')->findOrFail($showtimeId);

        // Get booked seats
        $bookedSeats = Booking::where('showtime_id', $showtimeId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('seats')
            ->toArray();

        $bookedSeatsArray = [];
        foreach ($bookedSeats as $seats) {
            $bookedSeatsArray = array_merge($bookedSeatsArray, explode(',', $seats));
        }

        return view('bookings.select-seats', compact('showtime', 'bookedSeatsArray'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'required|string'
        ]);

        $seats = $request->seats;

        try {
            // 🔐 FIX: Wrap dalam transaction dengan row-level lock untuk prevent race condition
            $booking = DB::transaction(function () use ($request, $seats) {
                // Lock showtime row untuk mencegah read oleh transaction lain
                $showtime = Showtime::lockForUpdate()
                    ->findOrFail($request->showtime_id);
                
                $totalPrice = count($seats) * $showtime->price;

                // Check if seats are available (within same transaction)
                $bookedSeats = Booking::where('showtime_id', $request->showtime_id)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->pluck('seats')
                    ->toArray();

                $bookedSeatsArray = [];
                foreach ($bookedSeats as $bookedSeat) {
                    $bookedSeatsArray = array_merge($bookedSeatsArray, explode(',', $bookedSeat));
                }

                foreach ($seats as $seat) {
                    if (in_array($seat, $bookedSeatsArray)) {
                        throw new \Exception("Kursi $seat sudah dipesan.");
                    }
                }

                // Create booking (still dalam transaction, atomic)
                return Booking::create([
                    'user_id' => Auth::id(),
                    'showtime_id' => $request->showtime_id,
                    'seats' => implode(',', $seats),
                    'total_price' => $totalPrice,
                    'booking_code' => 'BK' . strtoupper(Str::random(8)),
                    'status' => 'pending'
                ]);
            }, attempts: 3); // Retry 3 kali jika ada conflict

            $showtime = $booking->showtime;
            $totalPrice = $booking->total_price;

            return view('bookings.checkout', compact('booking', 'showtime', 'seats', 'totalPrice'));

        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'showtime_id' => $request->showtime_id,
                'seats' => $seats
            ]);

            return back()->with('error', 'Gagal membuat booking: ' . $e->getMessage());
        }
    }

    public function processPayment(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Create Midtrans transaction
        $snapToken = $this->midtransService->createTransaction($booking);

        return response()->json(['snap_token' => $snapToken]);
    }

    public function paymentCallback(Request $request)
    {
        \Log::info('=== MIDTRANS CALLBACK RECEIVED ===');
        \Log::info('Request data:', $request->all());
        
        $serverKey = config('services.midtrans.server_key');
        
        // Handle both raw request dan JSON body
        $order_id = $request->input('order_id') ?? $request->order_id;
        $status_code = $request->input('status_code') ?? $request->status_code;
        $gross_amount = $request->input('gross_amount') ?? $request->gross_amount;
        $signature_key = $request->input('signature_key') ?? $request->signature_key;
        $transaction_status = $request->input('transaction_status') ?? $request->transaction_status;
        
        \Log::info("Order ID: {$order_id}, Status Code: {$status_code}, Transaction Status: {$transaction_status}");
        
        // Verify signature
        $hashed = hash("sha512", $order_id . $status_code . $gross_amount . $serverKey);
        
        if ($hashed !== $signature_key) {
            \Log::error('SIGNATURE MISMATCH', ['expected' => $hashed, 'received' => $signature_key]);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $booking = Booking::where('booking_code', $order_id)->first();
        
        if (!$booking) {
            \Log::error("Booking not found for order: {$order_id}");
            return response()->json(['error' => 'Booking not found'], 404);
        }

        \Log::info("Found booking: {$booking->id}, Current status: {$booking->status}");

        // Only update if status is still pending
        if ($booking->status === 'pending') {
            if ($transaction_status === 'capture' || $transaction_status === 'settlement') {
                \Log::info("Updating booking {$booking->id} to confirmed");
                $booking->update(['status' => 'confirmed']);
                
                // Update available seats on showtime
                $seatsCount = count(explode(',', $booking->seats));
                $booking->showtime->decrement('available_seats', $seatsCount);
                
                \Log::info("Booking {$booking->id} confirmed. Seats decreased by {$seatsCount}");
            } elseif ($transaction_status === 'deny' || $transaction_status === 'expire' || $transaction_status === 'cancel') {
                \Log::info("Updating booking {$booking->id} to cancelled. Reason: {$transaction_status}");
                $booking->update(['status' => 'cancelled']);
            }
        } else {
            \Log::info("Booking {$booking->id} status is {$booking->status}, skipping update");
        }

        \Log::info('=== CALLBACK PROCESSING COMPLETE ===');
        return response()->json(['status' => 'ok']);
    }

    public function success(Request $request)
    {
        // Get booking dari request parameter untuk safety
        $bookingId = $request->query('booking_id');
        
        if (!$bookingId) {
            return redirect()->route('home')->with('error', 'Booking tidak ditemukan.');
        }

        $booking = Auth::user()->bookings()->findOrFail($bookingId);

        return view('bookings.success', compact('booking'));
    }

    public function checkStatus($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        // Verify user owns this booking
        if ($booking->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['status' => $booking->status]);
    }

    public function validateCheckout(Request $request)
    {
        /**
         * 🔐 FIX #2: Pre-flight validation sebelum form submit
         * User dapat feedback instant jika kursi tidak tersedia
         * Mengurangi bad UX dari server round-trip yang lama
         */
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'required|string'
        ]);

        $showtimeId = $request->showtime_id;
        $seats = $request->seats;

        // Check booked seats
        $bookedSeats = Booking::where('showtime_id', $showtimeId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('seats')
            ->toArray();

        $bookedSeatsArray = [];
        foreach ($bookedSeats as $bookedSeat) {
            $bookedSeatsArray = array_merge($bookedSeatsArray, explode(',', $bookedSeat));
        }

        // Check mana yang tidak available
        $unavailableSeats = [];
        foreach ($seats as $seat) {
            if (in_array($seat, $bookedSeatsArray)) {
                $unavailableSeats[] = $seat;
            }
        }

        if (count($unavailableSeats) > 0) {
            return response()->json([
                'valid' => false,
                'message' => 'Kursi ' . implode(', ', $unavailableSeats) . ' sudah dipesan oleh pengguna lain.',
                'unavailable_seats' => $unavailableSeats
            ], 422);
        }

        return response()->json(['valid' => true]);
    }

    public function confirmPayment(Request $request)
    {
        /**
         * Optional method: Client-side dapat langsung trigger konfirmasi pembayaran
         * tanpa harus menunggu callback dari Midtrans
         * 
         * Ini sebagai fallback jika callback dari Midtrans terlambat
         */
        $booking = Booking::findOrFail($request->booking_id);

        // Verify user owns this booking
        if ($booking->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // If status is still pending, update to confirmed
        if ($booking->status === 'pending') {
            \Log::info("Client-side payment confirmation for booking: {$booking->id}");
            $booking->update(['status' => 'confirmed']);
            
            // Update available seats
            $seatsCount = count(explode(',', $booking->seats));
            $booking->showtime->decrement('available_seats', $seatsCount);
        }

        return response()->json(['status' => 'ok']);
    }
}
