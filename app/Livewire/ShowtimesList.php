<?php

namespace App\Livewire;

use App\Models\Movie;
use App\Models\Showtime;
use Livewire\Component;
use Livewire\WithPagination;

class ShowtimesList extends Component
{
    use WithPagination;

    public $movieId = '';
    public $selectedDate = '';
    public $searchMovie = '';

    protected $queryString = ['movieId', 'selectedDate', 'searchMovie'];

    public function updatingMovieId()
    {
        $this->resetPage();
    }

    public function updatingSelectedDate()
    {
        $this->resetPage();
    }

    public function updatingSearchMovie()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Showtime::with('movie')
            ->where('show_date', '>=', now()->toDateString());

        if ($this->movieId) {
            $query->where('movie_id', $this->movieId);
        }

        if ($this->selectedDate) {
            $query->where('show_date', $this->selectedDate);
        }

        if ($this->searchMovie) {
            $query->whereHas('movie', function ($q) {
                $q->where('title', 'like', '%' . $this->searchMovie . '%');
            });
        }

        $showtimes = $query->orderBy('show_date')
                           ->orderBy('show_time')
                           ->paginate(12);

        $movies = Movie::where('status', 'now_showing')->get();
        $upcomingDates = Showtime::where('show_date', '>=', now()->toDateString())
                                  ->distinct()
                                  ->pluck('show_date')
                                  ->take(7);

        return view('livewire.showtimes-list', [
            'showtimes' => $showtimes,
            'movies' => $movies,
            'upcomingDates' => $upcomingDates,
        ]);
    }
}
