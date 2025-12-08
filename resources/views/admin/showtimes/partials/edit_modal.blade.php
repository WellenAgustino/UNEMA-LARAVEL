<!-- Edit Showtime Modal -->
<div class="modal fade" id="editShowtimeModal{{ $showtime->id }}" tabindex="-1" aria-labelledby="editShowtimeModalLabel{{ $showtime->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
            <form action="{{ route('admin.showtimes.update', $showtime->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header" style="border-color: var(--light-blue);">
                    <h5 class="modal-title" id="editShowtimeModalLabel{{ $showtime->id }}">Edit Jadwal Tayang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Film</label>
                        <select class="form-select" name="movie_id" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                            @foreach($allMovies as $movie)
                                <option value="{{ $movie->id }}" {{ $showtime->movie_id == $movie->id ? 'selected' : '' }}>{{ $movie->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Tayang</label>
                            <input type="date" class="form-control" name="show_date" value="{{ $showtime->show_date->format('Y-m-d') }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Tayang</label>
                            <input type="time" class="form-control" name="show_time" value="{{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Studio</label>
                        <input type="text" class="form-control" name="studio" value="{{ $showtime->studio }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga Tiket (Rp)</label>
                            <input type="number" class="form-control" name="price" value="{{ $showtime->price }}" min="0" step="1000" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Kursi</label>
                            <input type="number" class="form-control" name="total_seats" value="{{ $showtime->total_seats }}" min="1" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <small><i class="bi bi-info-circle"></i> Kursi tersedia saat ini: <strong>{{ $showtime->available_seats }}</strong> dari {{ $showtime->total_seats }}</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-color: var(--light-blue);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
