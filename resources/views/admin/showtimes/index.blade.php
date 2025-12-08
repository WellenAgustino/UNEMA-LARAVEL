@extends('layouts.app')

@section('title', 'Kelola Jadwal Tayang - UNEMA Cinema')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title mb-0">Kelola Jadwal Tayang</h1>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShowtimeModal">
            <i class="bi bi-plus-circle"></i> Tambah Jadwal
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table" style="color: var(--text-color);">
            <thead style="border-color: var(--light-blue);">
                <tr>
                    <th>Film</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Studio</th>
                    <th>Harga</th>
                    <th>Kursi Tersedia</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody style="border-color: var(--light-blue);">
                @forelse($showtimes as $showtime)
                    <tr style="border-color: var(--light-blue);">
                        <td>{{ $showtime->movie->title }}</td>
                        <td>{{ $showtime->show_date->format('d M Y') }}</td>
                        <td>{{ $showtime->show_time }}</td>
                        <td>{{ $showtime->studio }}</td>
                        <td>Rp {{ number_format($showtime->price, 0, ',', '.') }}</td>
                        <td>{{ $showtime->available_seats }} / {{ $showtime->total_seats }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editShowtimeModal{{ $showtime->id }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteShowtime({{ $showtime->id }})">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="color: var(--text-muted);">
                            Tidak ada jadwal tayang
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $showtimes->links() }}
    </div>
</div>

<!-- Add Showtime Modal -->
<div class="modal fade" id="addShowtimeModal" tabindex="-1" aria-labelledby="addShowtimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
            <div class="modal-header" style="border-color: var(--light-blue);">
                <h5 class="modal-title" id="addShowtimeModalLabel">Tambah Jadwal Tayang Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addShowtimeForm">
                    <div class="mb-3">
                        <label class="form-label">Film</label>
                        <select class="form-select" name="movie_id" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                            <option value="">Pilih Film</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="show_date" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="time" class="form-control" name="show_time" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Studio</label>
                        <input type="text" class="form-control" name="studio" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="price" step="1000" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Kursi</label>
                        <input type="number" class="form-control" name="total_seats" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-color: var(--light-blue);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitAddShowtime()">Tambah</button>
            </div>
        </div>
    </div>
</div>

<script>
    function submitAddShowtime() {
        alert('Fitur ini memerlukan backend API untuk menambah jadwal tayang');
    }

    function deleteShowtime(id) {
        if (confirm('Yakin ingin menghapus jadwal tayang ini?')) {
            alert('Fitur ini memerlukan backend API untuk menghapus jadwal tayang');
        }
    }
</script>
@endsection
