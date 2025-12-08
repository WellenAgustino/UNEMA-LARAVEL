<div>
    {{-- Pembungkus utama --}}
    {{-- RESPONSIVE: p-3 di mobile, p-lg-4 di desktop --}}
    <div class="p-3 p-lg-4 rounded" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
        <div class="row">
            
            {{-- ================= KOLOM KIRI: FORM ================= --}}
            <div class="col-lg-4 mb-4 mb-lg-0">
                @auth
                    <form wire:submit.prevent="submitReview">
                        <h3 class="mb-3" style="color: var(--primary-color-light);">
                            @if($editingReviewId)
                                Edit Ulasan Anda
                            @else
                                Tulis Ulasan
                            @endif
                        </h3>

                        {{-- Rating Bintang --}}
                        <div class="mb-3">
                            <label class="form-label">Rating Anda</label>
                            {{-- RESPONSIVE: justify-content-between di mobile kecil agar bintang tersebar rata, start di desktop --}}
                            <div class="d-flex justify-content-between justify-content-sm-start gap-sm-2" style="font-size: 1.5rem; color: #ffc107; cursor: pointer;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $rating ? 'bi-star-fill' : 'bi-star' }}"
                                       wire:click="$set('rating', {{ $i }})"
                                       wire:key="rating-{{ $i }}"></i>
                                @endfor
                            </div>
                            @error('rating') <div class="text-danger mt-1" style="font-size: 0.875em;">{{ $message }}</div> @enderror
                        </div>

                        {{-- Komentar --}}
                        <div class="mb-3">
                            <label for="comment" class="form-label">Ulasan Anda</label>
                            <textarea wire:model.defer="comment" id="comment" class="form-control" rows="4"
                                      placeholder="Bagaimana pendapat Anda tentang film ini?"
                                      style="background-color: var(--dark-blue); color: var(--text-color); border-color: var(--light-blue);"></textarea>
                            @error('comment') <div class="text-danger mt-1" style="font-size: 0.875em;">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex flex-wrap justify-content-between gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1 flex-lg-grow-0">
                                <span wire:loading.remove wire:target="submitReview">
                                    <i class="bi bi-send-fill"></i>
                                    @if($editingReviewId)
                                        Update
                                    @else
                                        Kirim
                                    @endif
                                </span>
                                <span wire:loading wire:target="submitReview">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    ...
                                </span>
                            </button>
                            
                            <div class="d-flex gap-2">
                                @if($editingReviewId)
                                    <button type="button" wire:click="cancelEdit" class="btn btn-secondary">
                                        Batal
                                    </button>
                                @endif
                                @if($userReview)
                                    {{-- Tombol Hapus dengan SweetAlert --}}
                                    <button type="button" onclick="confirmDelete({{ $userReview->id }})"
                                            class="btn btn-danger">
                                        <i class="bi bi-trash-fill"></i> Hapus
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                @else
                    <div class="text-center p-4 border rounded" style="border-color: var(--light-blue) !important;">
                        <h4 style="color: var(--primary-color-light);">Ingin Memberi Ulasan?</h4>
                        <p style="color: var(--text-muted);">Silakan <a href="{{ route('login') }}">login</a> untuk menulis ulasan Anda.</p>
                    </div>
                @endauth
            </div>

            {{-- ================= KOLOM KANAN: LIST ULASAN ================= --}}
            <div class="col-lg-8 pt-4 pt-lg-0 border-top border-lg-start border-lg-top-0" style="border-color: var(--light-blue) !important;">
                
                {{-- Header Daftar Ulasan & Filter --}}
                <div class="d-block d-lg-flex justify-content-lg-between align-items-lg-center mb-3">
                    <h3 class="mb-0" style="color: var(--primary-color-light);">Ulasan ({{ $totalReviews }})</h3>
                    
                    {{-- RESPONSIVE FILTER: w-100 di mobile agar dropdown lebar --}}
                    <div class="d-flex gap-2 mt-3 mt-lg-0 w-100 w-lg-auto">
                        {{-- Filter Rating --}}
                        {{-- flex-fill: Di mobile membagi lebar 50:50. flex-lg-grow-0: Di desktop balik ke auto --}}
                        <select wire:model.live="filterRating" class="form-select form-select-sm flex-fill flex-lg-grow-0" 
                                style="background-color: var(--dark-blue); color: var(--text-color); border-color: var(--light-blue);">
                            <option value="">Semua Bintang</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} Bintang</option>
                            @endfor
                        </select>
                        {{-- Urutkan --}}
                        <select wire:model.live="sortBy" class="form-select form-select-sm flex-fill flex-lg-grow-0" 
                                style="background-color: var(--dark-blue); color: var(--text-color); border-color: var(--light-blue);">
                            <option value="latest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="highest">Rating Tertinggi</option>
                            <option value="lowest">Rating Terendah</option>
                        </select>
                    </div>
                </div>

                {{-- Indikator Loading --}}
                <div wire:loading.flex class="justify-content-center align-items-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                {{-- Daftar Ulasan --}}
                <div wire:loading.remove>
                    @if($reviews->count() > 0)
                        <div class="list-group">
                            @foreach($reviews as $review)
                                <div class="list-group-item mb-3 rounded p-3" style="background-color: var(--dark-blue); border: 1px solid var(--light-blue);">
                                    
                                    {{-- RESPONSIVE HEADER ITEM: Stack vertikal di HP kecil, horizontal di tablet/desktop --}}
                                    <div class="d-flex w-100 justify-content-between align-items-start align-items-sm-center flex-column flex-sm-row">
                                        <h5 class="mb-1 text-white"><i class="bi bi-person-circle me-2"></i>{{ $review->user->username }}</h5>
                                        <small class="mt-1 mt-sm-0" style="color: var(--text-muted);">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                    
                                    <div class="mb-2 mt-1" style="color: #ffc107;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                    
                                    <p class="mb-1 fst-italic text-break" style="color: var(--text-color);">"{{ $review->comment }}"</p>

                                    @auth
                                        @if(auth()->id() == $review->user_id || auth()->user()->is_admin)
                                            <div class="text-end mt-2">
                                                @if(auth()->id() == $review->user_id)
                                                <button wire:click="startEdit({{ $review->id }})" class="btn btn-sm btn-outline-secondary py-1 px-2">
                                                    <i class="bi bi-pencil-fill"></i> <span class="d-inline d-sm-none">Edit</span>
                                                </button>
                                                @endif
                                                
                                                <button type="button" onclick="confirmDelete({{ $review->id }})"
                                                        class="btn btn-sm btn-outline-danger py-1 px-2">
                                                    <i class="bi bi-trash-fill"></i> <span class="d-inline d-sm-none">Hapus</span>
                                                </button>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if ($reviews->hasPages())
                            <div class="mt-4 d-flex justify-content-center justify-content-lg-end">
                                {{ $reviews->links() }}
                            </div>
                        @endif

                    @else
                        <div class="text-center p-5">
                            <p style="color: var(--text-muted);">
                                @if($filterRating)
                                    Tidak ada ulasan dengan rating {{ $filterRating }} bintang.
                                @else
                                    Jadilah yang pertama memberi ulasan untuk film ini!
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(reviewId) {
        Swal.fire({
            title: 'Hapus Ulasan?',
            text: "Apakah Anda yakin ingin menghapus ulasan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            // Styling manual agar sesuai dengan tema gelap
            background: 'var(--medium-blue)',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('deleteReview', reviewId);
            }
        })
    }
</script>
@endpush