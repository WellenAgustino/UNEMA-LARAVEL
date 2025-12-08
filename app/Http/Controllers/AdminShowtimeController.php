<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminShowtimeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'studio' => 'required|string|max:255',
            'show_date' => 'required|date',
            'show_time' => 'required|date_format:H:i',
            'price' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1',
        ]);

        $validated['available_seats'] = $validated['total_seats'];

        Showtime::create($validated);

        return back()->with('success', 'Showtime added successfully.');
    }

    public function update(Request $request, Showtime $showtime)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'studio' => 'required|string|max:255',
            'show_date' => 'required|date',
            'show_time' => 'required|date_format:H:i',
            'price' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1'
        ]);

        // Hitung jumlah kursi yang sudah dipesan
        $bookedSeats = $showtime->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->sum(function($b) {
                return count(explode(',', $b->seats));
        });

        // total_seats baru tidak boleh lebih kecil dari kursi yang sudah dipesan
        if ($validated['total_seats'] < $bookedSeats) {
            return back()->with('error', "Total seats cannot be reduced below the number of already booked seats ($bookedSeats).");
        }

        $showtime->update($validated);

        return back()->with('success', 'Showtime updated successfully.');
    }

    public function destroy(Showtime $showtime)
    {
        try {
            // Check if there are any bookings associated with this showtime
            if ($showtime->bookings()->exists()) {
                return back()->with('error', 'Cannot delete showtime because it has active bookings.');
            }

            $showtime->delete();

            return back()->with('success', 'Showtime deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting showtime: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the showtime.');
        }
    }
}
