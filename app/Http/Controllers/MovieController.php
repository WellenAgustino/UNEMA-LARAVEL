<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        // Get top rated movies for featured section
        $featured = Movie::where('status', 'now_showing')
            ->orderBy('rating', 'desc')
            ->first();

        // Get latest movies for slideshow (top 5)
        $topMovies = Movie::where('status', 'now_showing')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get all movies sorted by rating
        $movies = Movie::where('status', 'now_showing')
            ->orderBy('rating', 'desc')
            ->get();

        return view('movies.index', compact('featured', 'topMovies', 'movies'));
    }

    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        $reviews = $movie->reviews()->with('user')->latest()->get();

        $avgRating = $reviews->avg('rating') ?? $movie->rating;

        return view('movies.detail', compact('movie', 'reviews', 'avgRating'));
    }
}
