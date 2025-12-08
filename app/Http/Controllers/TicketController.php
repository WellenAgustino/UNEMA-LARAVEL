<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Auth::user()->bookings()
            ->with('showtime.movie')
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    public function cancel(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized');
        }

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Hanya tiket yang sudah dikonfirmasi yang dapat dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Tiket berhasil dibatalkan.');
    }
}
