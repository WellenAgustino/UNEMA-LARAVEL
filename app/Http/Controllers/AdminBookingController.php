<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Menampilkan halaman tiket yang siap cetak.
     */
    public function ticket(Booking $booking)
    {
        // Menggunakan layout minimalis untuk cetak
        return view('admin.bookings.ticket', compact('booking'));
    }

    public function approve(Booking $booking)
    {
        // Validasi: Hanya status 'pending' yang bisa di-approve
        if ($booking->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pemesanan dengan status pending yang dapat disetujui.'
            ], 409); // 409 Conflict
        }

        try {
            DB::transaction(function () use ($booking) {
                // Ubah status booking menjadi 'confirmed'
                $booking->update(['status' => 'confirmed']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Pemesanan berhasil dikonfirmasi.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error approving booking: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengkonfirmasi pesanan.'], 500);
        }
    }

    public function cancel(Booking $booking)
    {
        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking sudah dibatalkan sebelumnya.');
        }

        try {
            DB::transaction(function () use ($booking) {
                // Ubah status booking menjadi 'cancelled'
                $booking->update(['status' => 'cancelled']);
            });

            return back()->with('success', 'Booking berhasil dibatalkan.');
        } catch (\Exception $e) {
            Log::error('Error cancelling booking: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membatalkan booking.');
        }
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete(); // Hapus booking dari database
            // Redirect ke halaman daftar booking dengan pesan sukses
            return redirect()->route('admin.dashboard', ['tab' => 'bookings'])->with('success', 'Booking berhasil dihapus secara permanen.');
        } catch (\Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus booking.');
        }
    }
}