<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header" style="border-color: var(--light-blue);">
                    <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User: {{ $user->username }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $user->full_name }}" required style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" style="background: var(--dark-blue); border-color: var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_admin" id="isAdminEdit{{ $user->id }}" value="1" {{ $user->is_admin ? 'checked' : '' }}>
                            <label class="form-check-label" for="isAdminEdit{{ $user->id }}">
                                Jadikan Admin
                            </label>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <small><i class="bi bi-info-circle"></i> Bergabung: {{ $user->created_at->format('d M Y H:i') }}</small>
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
