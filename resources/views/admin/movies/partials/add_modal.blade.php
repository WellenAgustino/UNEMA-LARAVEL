<div class="modal fade" id="addMovieModal" tabindex="-1" aria-labelledby="addMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
            <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="border-color: var(--light-blue);">
                    <h5 class="modal-title" id="addMovieModalLabel">Tambah Film Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Input Standar ... --}}
                    <div class="mb-3">
                        <label class="form-label">Judul Film</label>
                        <input type="text" class="form-control" name="title" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Genre</label>
                        <input type="text" class="form-control" name="genre" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);"></textarea>
                    </div>

                    {{-- LOGIKA POSTER --}}
                    <div class="mb-3 p-3 border rounded" style="border-color: var(--light-blue) !important;">
                        <label class="form-label fw-bold">Poster Film</label>

                        <div class="mb-2">
                            <label class="small text-muted">Opsi A: Upload Gambar</label>
                            <input type="file"
                                   class="form-control"
                                   name="poster_file"
                                   id="addFileInput"
                                   accept="image/*"
                                   onchange="document.getElementById('addUrlInput').value = ''"
                                   style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>

                        <div class="text-center text-muted my-2 small">- ATAU -</div>

                        <div>
                            <label class="small text-muted">Opsi B: Link URL</label>
                            <input type="url"
                                   class="form-control"
                                   name="poster_url"
                                   id="addUrlInput"
                                   placeholder="https://..."
                                   oninput="document.getElementById('addFileInput').value = ''"
                                   style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>

                    {{-- Input Sisa (Rating, Duration, dll) --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rating</label>
                            <input type="number" class="form-control" name="rating" step="0.1" min="0" max="10" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Durasi (menit)</label>
                            <input type="number" class="form-control" name="duration" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Rilis</label>
                        <input type="date" class="form-control" name="release_date" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Trailer</label>
                        <input type="url" class="form-control" name="trailer_url" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                            <option value="now_showing">Sedang Tayang</option>
                            <option value="coming_soon">Segera Hadir</option>
                        </select>
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
