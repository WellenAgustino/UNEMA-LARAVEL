<?php

namespace App\Livewire;

use App\Models\Review;
use App\Models\Movie;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MovieReviews extends Component
{
    use WithPagination;

    public $movieId;
    public $rating = 5;
    public $comment = '';
    public $sortBy = 'latest';
    public $filterRating = '';
    public $userReview = null;
    public $editingReviewId = null;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:10|max:500',
    ];

    protected $messages = [
        'rating.required' => 'Rating harus dipilih',
        'rating.integer' => 'Rating harus berupa angka',
        'rating.min' => 'Rating minimal 1 bintang',
        'rating.max' => 'Rating maksimal 5 bintang',
        'comment.required' => 'Komentar tidak boleh kosong',
        'comment.min' => 'Komentar minimal 10 karakter',
        'comment.max' => 'Komentar maksimal 500 karakter',
    ];

    public function mount($movieId)
    {
        $this->movieId = $movieId;

        if (Auth::check()) {
            $this->userReview = Review::where('movie_id', $movieId)
                ->where('user_id', Auth::id())
                ->first();
        }
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function updatingFilterRating()
    {
        $this->resetPage();
    }

    /**
     * 🔥 FUNGSI PENTING UNTUK UPDATE RATING FILM
     */
    private function updateMovieRating()
    {
        $avgRating = Review::where('movie_id', $this->movieId)->avg('rating') ?? 0;

        Movie::where('id', $this->movieId)->update([
            'rating' => round($avgRating, 1)
        ]);
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            $this->dispatch('error', 'Silakan login terlebih dahulu');
            return;
        }

        $this->validate();

        if ($this->userReview) {
            $this->userReview->update([
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);
            $this->dispatch('success', 'Ulasan berhasil diperbarui');
        } else {
            Review::create([
                'movie_id' => $this->movieId,
                'user_id' => Auth::id(),
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);
            $this->dispatch('success', 'Ulasan berhasil ditambahkan');
        }

        // 🔥 Update rating film setelah tambah/edit review
        $this->updateMovieRating();

        $this->reset(['rating', 'comment', 'editingReviewId']);
        $this->userReview = Review::where('movie_id', $this->movieId)
            ->where('user_id', Auth::id())
            ->first();
        $this->resetPage();
    }

    public function startEdit($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        if ($review->user_id !== Auth::id()) {
            $this->dispatch('error', 'Anda tidak memiliki akses untuk mengedit ulasan ini');
            return;
        }

        $this->editingReviewId = $review->id;
        $this->rating = $review->rating;
        $this->comment = $review->comment;
    }

    public function cancelEdit()
    {
        $this->reset(['rating', 'comment', 'editingReviewId']);
    }

    public function deleteReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        if ($review->user_id !== Auth::id()) {
            $this->dispatch('error', 'Anda tidak memiliki akses untuk menghapus ulasan ini');
            return;
        }

        $review->delete();
        $this->userReview = null;

        // 🔥 Update rating film setelah hapus review
        $this->updateMovieRating();

        $this->dispatch('success', 'Ulasan berhasil dihapus');
        $this->resetPage();
    }

    public function render()
    {
        $query = Review::where('movie_id', $this->movieId)
            ->with('user');

        if ($this->filterRating) {
            $query->where('rating', $this->filterRating);
        }

        if ($this->sortBy === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($this->sortBy === 'highest') {
            $query->orderBy('rating', 'desc');
        } elseif ($this->sortBy === 'lowest') {
            $query->orderBy('rating', 'asc');
        }

        $reviews = $query->paginate(5);

        $averageRating = Review::where('movie_id', $this->movieId)->avg('rating') ?? 0;
        $totalReviews = Review::where('movie_id', $this->movieId)->count();
        $ratingDistribution = Review::where('movie_id', $this->movieId)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating');

        return view('livewire.movie-reviews', [
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
            'ratingDistribution' => $ratingDistribution,
        ]);
    }
}
