<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminMovieController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // Max 10MB
            'poster_url'  => 'nullable|url',
            'trailer_url' => 'nullable|url',
            'duration' => 'required|integer|min:1',
            'rating' => 'required|numeric|min:0|max:10',
            'release_date' => 'required|date',
            'genre' => 'required|string|max:100',
            'status' => 'required|in:now_showing,coming_soon',
        ]);

        // Custom Validasi: Pastikan salah satu ada
        $validator->after(function ($validator) use ($request) {
            if (!$request->hasFile('poster_file') && empty($request->poster_url)) {
                $validator->errors()->add('poster_file', 'Harap upload gambar ATAU masukkan link URL poster.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal validasi: ' . $validator->errors()->first());
        }

        try {
            $finalPosterUrl = null;

            // PRIORITAS 1: File Upload
            if ($request->hasFile('poster_file')) {
                // Simpan file fisik
                $path = $request->file('poster_file')->store('posters', 'public');

                // FIX: Simpan sebagai PATH relatif (/storage/...), bukan URL lengkap (http://...)
                // Agar di Blade terdeteksi sebagai "File Upload"
                $finalPosterUrl = '/storage/' . $path;

            }
            // PRIORITAS 2: Link URL
            elseif ($request->filled('poster_url')) {
                $finalPosterUrl = $request->poster_url;
            }

            Movie::create([
                'title' => $request->title,
                'description' => $request->description,
                'poster_url' => $finalPosterUrl,
                'trailer_url' => $request->trailer_url,
                'duration' => $request->duration,
                'rating' => $request->rating,
                'release_date' => $request->release_date,
                'genre' => $request->genre,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.dashboard', ['tab' => 'movies'])->with('success', 'Film berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Movie $movie)
    {
        // 1. Bersihkan Logika: Jika upload file, abaikan input URL
        if ($request->hasFile('poster_file')) {
            $request->merge(['poster_url' => null]);
        }

        // 2. Validasi
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // Max 10MB
            'poster_url'  => 'nullable|url',
            'trailer_url' => 'nullable|url',
            'duration' => 'required|integer|min:1',
            'rating' => 'required|numeric|min:0|max:10',
            'release_date' => 'required|date',
            'genre' => 'required|string|max:100',
            'status' => 'required|in:now_showing,coming_soon',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal validasi: ' . $validator->errors()->first());
        }

        $data = $request->except(['_token', '_method', 'poster_file', 'poster_url']);

        try {
            // 3. Logika Update Poster

            // OPSI A: User Upload File Baru
            if ($request->hasFile('poster_file')) {

                // Hapus file lama jika ada
                $this->deleteOldPoster($movie->poster_url);

                // Upload baru
                $path = $request->file('poster_file')->store('posters', 'public');

                // FIX: Simpan sebagai PATH relatif
                $data['poster_url'] = '/storage/' . $path;

            }
            // OPSI B: User Mengisi Link URL Baru
            elseif ($request->filled('poster_url')) {

                // Jika URL beda dengan yang lama
                if ($request->poster_url !== $movie->poster_url) {
                    $this->deleteOldPoster($movie->poster_url);
                    $data['poster_url'] = $request->poster_url;
                }
            }

            $movie->update($data);

            return redirect()->route('admin.dashboard', ['tab' => 'movies'])->with('success', 'Film berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function destroy(Movie $movie)
    {
        $this->deleteOldPoster($movie->poster_url);
        $movie->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'movies'])->with('success', 'Film berhasil dihapus!');
    }

    // Helper function
    private function deleteOldPoster($url)
    {
        // Cek apakah ini file lokal (mengandung /storage/)
        if ($url && strpos($url, '/storage/') !== false) {
            // Mengambil path relatif setelah /storage/
            // Contoh: /storage/posters/abc.jpg -> posters/abc.jpg
            $path = str_replace('/storage/', '', parse_url($url, PHP_URL_PATH));

            // Bersihkan slash di awal
            $path = ltrim($path, '/');

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
