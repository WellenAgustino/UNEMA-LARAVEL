@extends('layouts.app')
@section('title', 'Kelola Film - UNEMA Cinema')
@section('content')

{{ $movies->links('vendor.pagination.tailwind') }}


<div class="container-fluid px-3 px-md-5 py-3 py-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center mb-4">
        <h1 class="section-title mb-3 mb-md-0 text-center text-md-start">Kelola Film</h1>
        <a href="#" class="btn btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addMovieModal">
            <i class="bi bi-plus-circle"></i> Tambah Film
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table" style="color: var(--text-color);">
            <thead style="border-color: var(--light-blue);">
                <tr>
                    <th>Poster</th>
                    <th>Judul</th>
                    <th>Genre</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Durasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody style="border-color: var(--light-blue);">
                @forelse($movies as $movie)
                    <tr style="border-color: var(--light-blue);">
                        <td>
                            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" style="width: 50px; height: 75px; object-fit: cover; border-radius: 5px;">
                        </td>
                        <td>{{ $movie->title }}</td>
                        <td>{{ $movie->genre }}</td>
                        <td>
                            <span style="color: #ffd700;">
                                <i class="bi bi-star-fill"></i> {{ $movie->rating }}
                            </span>
                        </td>
                        <td>
                            <span class="badge rounded-pill" style="background-color: {{ $movie->status === 'now_showing' ? '#4caf50' : '#ff9800' }}; color: white;">
                                {{ ucfirst(str_replace('_', ' ', $movie->status)) }}
                            </span>
                        </td>
                        <td>{{ $movie->duration }} menit</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editMovieModal{{ $movie->id }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus film ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Movie Modal -->
                    @include('admin.movies.partials.edit_modal', ['movie' => $movie])
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5" style="color: var(--text-muted);">
                            Tidak ada film
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-5">

    </div>
</div>

@include('admin.movies.partials.add_modal')

@endsection
