<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DB::table('bookings')->delete();
        DB::table('reviews')->delete();
        DB::table('showtimes')->delete();
        DB::table('movies')->delete();
        DB::table('users')->delete();

        // Check if columns exist before inserting
        $userColumns = Schema::getColumnListing('users');

        $userData = [
            'username' => 'admin',
            'email' => 'admin@nema.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Only add these columns if they exist in the table
        if (in_array('full_name', $userColumns)) {
            $userData['full_name'] = 'Administrator';
        }
        if (in_array('phone', $userColumns)) {
            $userData['phone'] = '08123456789';
        }

        DB::table('users')->insert([
            $userData,
            [
                'username' => 'testuser',
                'email' => 'user@test.com',
                'password' => Hash::make('user123'),
                'full_name' => in_array('full_name', $userColumns) ? 'Test User' : null,
                'phone' => in_array('phone', $userColumns) ? '08123456780' : null,
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // ... (rest of the seeder code for movies, showtimes, reviews remains the same)
        // Insert movies
        DB::table('movies')->insert([
            [
                'title' => 'Captain America: The Winter Soldier',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'poster_url' => 'https://via.placeholder.com/300x450/4a9eff/ffffff?text=Captain+America',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 136,
                'rating' => 4.5,
                'release_date' => '2024-04-04',
                'genre' => 'Action, Adventure',
                'status' => 'now_showing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Avengers',
                'description' => 'Earth\'s mightiest heroes must come together to stop Loki from conquering Earth.',
                'poster_url' => 'https://via.placeholder.com/300x450/dc3545/ffffff?text=Avengers',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 143,
                'rating' => 4.8,
                'release_date' => '2024-05-01',
                'genre' => 'Action, Sci-Fi',
                'status' => 'now_showing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Iron Man',
                'description' => 'After being held captive, billionaire Tony Stark creates a unique weapon suit to fight evil.',
                'poster_url' => 'https://via.placeholder.com/300x450/ffc107/000000?text=Iron+Man',
                'trailer_url' => null,
                'duration' => 126,
                'rating' => 4.5,
                'release_date' => '2024-06-15',
                'genre' => 'Action, Adventure',
                'status' => 'coming_soon',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Insert showtimes
        DB::table('showtimes')->insert([
            [
                'movie_id' => 1,
                'show_date' => now()->addDays(1)->format('Y-m-d'),
                'show_time' => '13:00:00',
                'studio' => 'Studio 1',
                'price' => 50000.00,
                'available_seats' => 45,
                'total_seats' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'movie_id' => 1,
                'show_date' => now()->addDays(1)->format('Y-m-d'),
                'show_time' => '16:00:00',
                'studio' => 'Studio 1',
                'price' => 50000.00,
                'available_seats' => 50,
                'total_seats' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'movie_id' => 1,
                'show_date' => now()->addDays(1)->format('Y-m-d'),
                'show_time' => '19:00:00',
                'studio' => 'Studio 2',
                'price' => 60000.00,
                'available_seats' => 40,
                'total_seats' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'movie_id' => 2,
                'show_date' => now()->addDays(1)->format('Y-m-d'),
                'show_time' => '14:00:00',
                'studio' => 'Studio 3',
                'price' => 55000.00,
                'available_seats' => 48,
                'total_seats' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'movie_id' => 2,
                'show_date' => now()->addDays(1)->format('Y-m-d'),
                'show_time' => '20:00:00',
                'studio' => 'Studio 3',
                'price' => 65000.00,
                'available_seats' => 35,
                'total_seats' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Insert sample reviews
        DB::table('reviews')->insert([
            [
                'movie_id' => 1,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'Film yang sangat bagus! Action-nya menegangkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'movie_id' => 1,
                'user_id' => 1,
                'rating' => 4,
                'comment' => 'Visual effect-nya keren, tapi plot agak predictable.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
