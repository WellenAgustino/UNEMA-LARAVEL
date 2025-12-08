<div class="modal fade" id="editMovieModal{{ $movie->id }}" tabindex="-1" aria-labelledby="editMovieModalLabel{{ $movie->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
            <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header" style="border-color: var(--light-blue);">
                    <h5 class="modal-title" id="editMovieModalLabel{{ $movie->id }}">Edit Film: {{ $movie->title }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Input Judul --}}
                    <div class="mb-3">
                        <label class="form-label">Judul Film</label>
                        <input type="text" class="form-control" name="title" value="{{ $movie->title }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>

                    {{-- LOGIKA POSTER OTOMATIS --}}
                    <div class="mb-3 p-3 border rounded" style="border-color: var(--light-blue) !important;">
                        <label class="form-label fw-bold">Poster Film</label>

                        @if($movie->poster_url)
                            <div class="mb-3 d-flex align-items-center gap-3">
                                <img src="{{ $movie->poster_url }}" alt="Preview" style="width: 60px; height: 90px; object-fit: cover; border-radius: 5px;">
                                <div>
                                    <small class="text-muted d-block">Poster Saat Ini</small>
                                    {{-- Cek apakah ini File Lokal atau Link --}}
                                    @if(Str::startsWith($movie->poster_url, ['http://', 'https://']))
                                        <span class="badge bg-info">Link URL</span>
                                    @else
                                        <span class="badge bg-warning text-dark">File Upload</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="mb-2">
                            <label class="small text-muted">Ganti dengan Upload File:</label>
                            <input type="file"
                                   class="form-control"
                                   name="poster_file"
                                   id="fileInput{{ $movie->id }}"
                                   accept="image/*"
                                   onchange="document.getElementById('urlInput{{ $movie->id }}').value = ''"
                                   style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>

                        <div class="text-center text-muted my-2 small">- ATAU -</div>

                        <div>
                            <label class="small text-muted">Ganti dengan Link URL:</label>
                            <input type="url"
                                   class="form-control"
                                   name="poster_url"
                                   id="urlInput{{ $movie->id }}"
                                   {{-- FIX: Jangan tampilkan value jika itu path storage lokal --}}
                                   value="{{ Str::startsWith($movie->poster_url, ['http', 'https']) ? $movie->poster_url : '' }}"
                                   placeholder="https://..."
                                   oninput="document.getElementById('fileInput{{ $movie->id }}').value = ''"
                                   style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                        <small class="text-warning fst-italic mt-1 d-block" style="font-size: 0.8rem;">*Sistem otomatis memilih input yang terakhir diisi.</small>
                    </div>

                    {{-- Input Lainnya (Sama seperti sebelumnya) --}}
                    <div class="mb-3">
                        <label class="form-label">Genre</label>
                        <input type="text" class="form-control" name="genre" value="{{ $movie->genre }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">{{ $movie->description }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rating</label>
                            <input type="number" class="form-control" name="rating" value="{{ $movie->rating }}" step="0.1" min="0" max="10" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Durasi (menit)</label>
                            <input type="number" class="form-control" name="duration" value="{{ $movie->duration }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Rilis</label>
                        <input type="date" class="form-control" name="release_date" value="{{ $movie->release_date?->format('Y-m-d') }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Trailer</label>
                        <input type="url" class="form-control" name="trailer_url" value="{{ $movie->trailer_url }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                            <option value="now_showing" {{ $movie->status === 'now_showing' ? 'selected' : '' }}>Sedang Tayang</option>
                            <option value="coming_soon" {{ $movie->status === 'coming_soon' ? 'selected' : '' }}>Segera Hadir</option>
                        </select>
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
