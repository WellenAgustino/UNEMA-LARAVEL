<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $movies = [
            [
                'title' => 'Chronos: Beyond Time',
                'description' => 'Di tahun 2150, seorang ilmuwan muda secara tidak sengaja menemukan celah waktu yang dapat mengubah sejarah kemanusiaan. Ia harus memilih antara menyelamatkan keluarganya atau mencegah kiamat global yang disebabkan oleh paradoks waktu.',
                // Biru Gelap untuk tema Sci-Fi Futuristik
                'poster_url' => 'https://placehold.co/500x750/0f172a/ffffff?text=Chronos%3A+Beyond+Time',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 145,
                'rating' => 4.5,
                'release_date' => '2024-01-15',
                'genre' => 'Sci-Fi',
                'status' => 'now_showing',
            ],
            [
                'title' => 'The Silent Symphony',
                'description' => 'Kisah menyentuh hati tentang seorang pianis tuli yang berusaha menyusun mahakarya terbesarnya hanya dengan merasakan getaran musik. Sebuah drama tentang ketekunan, cinta, dan bahasa universal musik.',
                // Merah Marun Hangat untuk tema Drama Emosional
                'poster_url' => 'https://placehold.co/500x750/4a0404/ffffff?text=The+Silent+Symphony',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 120,
                'rating' => 4.8,
                'release_date' => '2023-11-10',
                'genre' => 'Drama',
                'status' => 'now_showing',
            ],
            [
                'title' => 'Cyber Runner 2099',
                'description' => 'Di kota Neo-Jakarta yang penuh lampu neon, seorang kurir data ilegal terjebak dalam konspirasi perusahaan raksasa. Dengan teknologi augmentasi usang, ia harus berlari lebih cepat dari para pemburu bayaran elit.',
                // Hijau Neon Gelap untuk tema Cyberpunk
                'poster_url' => 'https://placehold.co/500x750/064e3b/ffffff?text=Cyber+Runner+2099',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 135,
                'rating' => 4.2,
                'release_date' => '2024-03-01',
                'genre' => 'Action',
                'status' => 'now_showing',
            ],
            [
                'title' => 'Chef from Another World',
                'description' => 'Seorang ksatria dari dunia fantasi terlempar ke dapur restoran bintang lima di modern Tokyo. Alih-alih menggunakan pedang untuk melawan naga, ia menggunakan pisau dapur untuk memenangkan kompetisi memasak nasional.',
                // Oranye Cerah untuk tema Komedi/Makanan
                'poster_url' => 'https://placehold.co/500x750/f59e0b/000000?text=Chef+Isekai',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 110,
                'rating' => 3.9,
                'release_date' => '2024-02-14',
                'genre' => 'Comedy',
                'status' => 'now_showing',
            ],
            [
                'title' => 'Midnight Whispers',
                'description' => 'Sekelompok mahasiswa melakukan ekspedisi ke hutan terlarang di Kalimantan untuk mendokumentasikan flora langka, namun mereka menemukan bahwa legenda lokal tentang penjaga hutan bukanlah sekadar mitos.',
                // Hitam Pekat untuk tema Horror Misteri
                'poster_url' => 'https://placehold.co/500x750/000000/880000?text=Midnight+Whispers',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 105,
                'rating' => 3.7,
                'release_date' => '2023-10-31',
                'genre' => 'Horror',
                'status' => 'now_showing',
            ],
            [
                'title' => 'Ocean\'s Guardian',
                'description' => 'Dokumenter fiksi tentang tim peneliti yang menemukan spesies paus purba yang dianggap punah. Mereka berjuang melawan pemburu liar untuk melindungi rahasia terbesar lautan.',
                // Biru Laut Dalam untuk tema Petualangan Bawah Laut
                'poster_url' => 'https://placehold.co/500x750/1e3a8a/ffffff?text=Ocean%27s+Guardian',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 115,
                'rating' => 4.6,
                'release_date' => '2024-04-22',
                'genre' => 'Adventure',
                'status' => 'coming_soon',
            ],
            [
                'title' => 'Little Robot\'s Journey',
                'description' => 'Unit R-7, robot pembersih sampah kecil, menemukan sebuah benih tanaman terakhir di Bumi yang gersang. Ia memulai perjalanan berbahaya melintasi benua untuk mencari tanah subur yang tersisa.',
                // Teal/Tosca untuk tema Animasi Futuristik
                'poster_url' => 'https://placehold.co/500x750/14b8a6/000000?text=Little+Robot',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 95,
                'rating' => 4.9,
                'release_date' => '2024-06-20',
                'genre' => 'Animation',
                'status' => 'coming_soon',
            ],
            [
                'title' => 'The Last Duelist',
                'description' => 'Di era kerajaan fiktif, dua sahabat dipaksa bertarung di arena gladiator demi hiburan raja yang tiran. Kisah tentang persahabatan, pengkhianatan, dan kehormatan di ujung pedang.',
                // Merah Darah Gelap untuk tema Aksi Kolosal
                'poster_url' => 'https://placehold.co/500x750/7f1d1d/ffffff?text=The+Last+Duelist',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 150,
                'rating' => 4.0,
                'release_date' => '2024-05-15',
                'genre' => 'Action',
                'status' => 'coming_soon',
            ],
        ];

        foreach ($movies as $movie) {
            Movie::firstOrCreate(
                ['title' => $movie['title']],
                $movie
            );
        }
    }
}
