<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Component;
use Livewire\WithPagination;

class MoviesList extends Component
{
    use WithPagination;

    public $search = '';
    public $genre = '';
    public $status = 'now_showing';
    public $sortBy = 'rating';

    protected $queryString = ['search', 'genre', 'status', 'sortBy'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingGenre()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Movie::query();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        if ($this->genre) {
            $query->where('genre', 'like', '%' . $this->genre . '%');
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $movies = $query->orderBy($this->sortBy, $this->sortBy === 'rating' ? 'desc' : 'asc')
                        ->paginate(12);

        $genres = Movie::distinct()->pluck('genre')->filter()->values();

        return view('livewire.movies-list', [
            'movies' => $movies,
            'genres' => $genres,
        ]);
    }
}
