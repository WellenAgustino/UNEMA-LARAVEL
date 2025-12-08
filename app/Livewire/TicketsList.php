<?php

namespace App\Livewire;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TicketsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $searchMovie = '';
    public $filterStatus = '';

    public function updatingSearchMovie()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function getStatusClass($status)
    {
        return match ($status) {
            'confirmed' => 'status-confirmed',
            'pending' => 'status-pending',
            'cancelled' => 'status-cancelled',
            default => 'bg-secondary',
        };
    }

    public function cancelTicket($ticketId)
    {
        $ticket = Booking::where('id', $ticketId)
            ->where('user_id', Auth::id())
            ->first();

        if ($ticket && $ticket->status === 'confirmed') {
            $ticket->update(['status' => 'cancelled']);
            $this->dispatch('success', 'Tiket berhasil dibatalkan.');
        } else {
            $this->dispatch('error', 'Tiket tidak dapat dibatalkan.');
        }
    }

    public function render()
    {
        $query = Booking::where('user_id', Auth::id())
            ->with(['showtime.movie'])
            ->latest();

        if (!empty($this->searchMovie)) {
            $query->whereHas('showtime.movie', function ($q) {
                $q->where('title', 'like', '%' . $this->searchMovie . '%');
            });
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        $tickets = $query->paginate(4); // Menampilkan 4 tiket per halaman

        return view('livewire.tickets-list', [
            'tickets' => $tickets,
        ]);
    }
}