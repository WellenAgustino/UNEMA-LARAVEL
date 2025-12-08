<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard(Request $request)
    {
        $activeTab = $request->query('tab', 'dashboard');
        $allowedTabs = ['dashboard', 'movies', 'showtimes', 'bookings', 'users'];
        if (!in_array($activeTab, $allowedTabs)) {
            $activeTab = 'dashboard';
        }

        $viewData = ['activeTab' => $activeTab];

        if ($activeTab === 'dashboard') {
            $totalMovies = Movie::count();
            $totalShowtimes = Showtime::whereDate('show_date', '>=', Carbon::today())->count();
            $totalBookings = Booking::count();
            $totalUsers = User::where('is_admin', 0)->count();
            $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');
            $nowShowingMovies = Movie::where('status', 'now_showing')->count();
            $confirmedBookings = Booking::where('status', 'confirmed')->count();

            $viewData['stats'] = [
                'total_movies'       => $totalMovies,
                'now_showing'        => $nowShowingMovies,
                'upcoming_showtimes' => $totalShowtimes,
                'total_bookings'     => $totalBookings,
                'confirmed_bookings' => $confirmedBookings,
                'total_revenue'      => $totalRevenue,
                'total_users'        => $totalUsers,
            ];

            $viewData['recentBookings'] = Booking::with('user', 'showtime.movie')
                ->latest()
                ->limit(10)
                ->get();

            $viewData['popularMovies'] = Movie::select('movies.title', 'movies.poster_url')
                ->leftJoin('showtimes', 'movies.id', '=', 'showtimes.movie_id')
                ->leftJoin('bookings', function ($join) {
                    $join->on('showtimes.id', '=', 'bookings.showtime_id')
                        ->where('bookings.status', '=', 'confirmed');
                })
                ->selectRaw('COUNT(bookings.id) as booking_count, SUM(bookings.total_price) as revenue')
                ->groupBy('movies.id', 'movies.title', 'movies.poster_url')
                ->orderBy('booking_count', 'desc')
                ->limit(5)
                ->get();
        } else {
            switch ($activeTab) {
                case 'showtimes':
                    $viewData['showtimes'] = Showtime::with('movie')->latest()->paginate(10)->withQueryString();
                    $viewData['allMovies'] = Movie::orderBy('title')->get();
                    break;
                case 'bookings':
                    $viewData['bookings'] = Booking::with('user', 'showtime.movie')->latest()->paginate(10)->withQueryString();
                    break;
                case 'users':
                    $viewData['users'] = User::where('is_admin', false)->latest()->paginate(10)->withQueryString();
                    break;
                case 'movies':
                default:
                    $viewData['movies'] = Movie::latest()->paginate(10)->withQueryString();
                    break;
            }
        }

        return view('admin.dashboard', $viewData);
    }
}
