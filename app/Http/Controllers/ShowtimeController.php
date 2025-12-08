<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShowtimeController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $selectedDate = $request->get('date', now()->toDateString());
        $selectedGenre = $request->get('genre', 'all');

        // Validate date format
        try {
            $selectedDate = Carbon::createFromFormat('Y-m-d', $selectedDate)->toDateString();
        } catch (\Exception $e) {
            $selectedDate = now()->toDateString();
        }

        // Get available dates (next 7 days)
        $availableDates = [];
        for ($i = 0; $i < 7; $i++) {
            $availableDates[] = now()->addDays($i)->toDateString();
        }

        // Get unique genres from now_showing movies
        $genresRaw = Movie::where('status', 'now_showing')
            ->distinct()
            ->pluck('genre')
            ->toArray();
        
        $genres = [];
        foreach ($genresRaw as $genreString) {
            $genreList = array_map('trim', explode(',', $genreString));
            foreach ($genreList as $genre) {
                if (!in_array($genre, $genres) && !empty($genre)) {
                    $genres[] = $genre;
                }
            }
        }
        sort($genres);

        // Build query for showtimes
        $query = Showtime::with('movie')
            ->whereDate('show_date', $selectedDate)
            ->where('show_date', '>=', now()->toDateString());

        // Apply genre filter if selected
        if ($selectedGenre !== 'all') {
            $query->whereHas('movie', function ($q) use ($selectedGenre) {
                $q->where('genre', 'LIKE', '%' . $selectedGenre . '%');
            });
        }

        $showtimes = $query->orderBy('show_time', 'ASC')->get();

        // Group movies by ID with their schedules
        $moviesByDate = [];
        foreach ($showtimes as $showtime) {
            $movieId = $showtime->movie_id;
            
            if (!isset($moviesByDate[$movieId])) {
                $moviesByDate[$movieId] = [
                    'details' => [
                        'title' => $showtime->movie->title,
                        'poster_url' => $showtime->movie->poster_url,
                        'genre' => $showtime->movie->genre,
                        'duration' => $showtime->movie->duration,
                        'rating' => $showtime->movie->rating,
                    ],
                    'schedules' => []
                ];
            }
            
            $moviesByDate[$movieId]['schedules'][] = $showtime;
        }

        // Get all movies for fallback
        $movies = Movie::where('status', 'now_showing')->get();

        return view('showtimes.index', compact(
            'showtimes',
            'movies',
            'selectedDate',
            'selectedGenre',
            'availableDates',
            'genres',
            'moviesByDate'
        ));
    }

    public function getShowtimes($movieId)
    {
        $showtimes = Showtime::where('movie_id', $movieId)
            ->where('show_date', '>=', now()->toDateString())
            ->orderBy('show_date')
            ->orderBy('show_time')
            ->get();
        
        return response()->json($showtimes);
    }
}
