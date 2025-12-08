<!-- Add Showtime Modal -->
<div class="modal fade" id="addShowtimeModal" tabindex="-1" aria-labelledby="addShowtimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
            <form action="{{ route('admin.showtimes.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="border-color: var(--light-blue);">
                    <h5 class="modal-title" id="addShowtimeModalLabel">Tambah Jadwal Tayang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Film</label>
                        <select class="form-select" name="movie_id" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                            <option value="">-- Pilih Film --</option>
                            @foreach($allMovies as $movie)
                                <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Tayang</label>
                            <input type="date" class="form-control" name="show_date" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Tayang</label>
                            <input type="time" class="form-control" name="show_time" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Studio</label>
                        <input type="text" class="form-control" name="studio" placeholder="Contoh: Studio 1, Studio A" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga Tiket (Rp)</label>
                            <input type="number" class="form-control" name="price" min="0" step="1000" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Kursi</label>
                            <input type="number" class="form-control" name="total_seats" min="1" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-color: var(--light-blue);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
