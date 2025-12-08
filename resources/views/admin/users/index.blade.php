@extends('layouts.app')

@section('title', 'Kelola Pengguna - UNEMA Cinema')

@section('content')
{{-- WRAPPER UTAMA KONTEN --}}
<div class="container-fluid px-3 px-lg-5 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center mb-4 gap-3">
        <h1 class="section-title mb-0 h2">Kelola Pengguna</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-circle me-2"></i>Tambah Pengguna
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- TAMPILAN DESKTOP --}}
    <div class="table-responsive d-none d-lg-block rounded-3" style="border: 1px solid var(--light-blue);">
        <table class="table table-hover align-middle mb-0" style="color: var(--text-color);">
            <thead style="background-color: var(--medium-blue); border-bottom: 2px solid var(--light-blue);">
                <tr>
                    <th class="py-3 ps-4">Username</th>
                    <th class="py-3">Email</th>
                    <th class="py-3">Nama Lengkap</th>
                    <th class="py-3">Telepon</th>
                    <th class="py-3">Bergabung</th>
                    <th class="py-3 pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody style="border-color: var(--light-blue);">
                @forelse($users as $user)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->full_name ?? '-' }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="pe-4 text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteUser({{ $user->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TAMPILAN MOBILE --}}
    <div class="d-lg-none">
        @forelse($users as $user)
            <div class="card mb-3 shadow-sm" style="background: var(--medium-blue); border: 1px solid var(--light-blue); border-left: 5px solid var(--light-blue);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title fw-bold mb-1" style="color: var(--text-color);">{{ $user->username }}</h5>
                            <span class="badge bg-secondary"><i class="bi bi-calendar-event me-1"></i>{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none p-0" type="button" data-bs-toggle="dropdown" style="color: var(--text-color);">
                                <i class="bi bi-three-dots-vertical fs-4"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="background: var(--dark-blue); border: 1px solid var(--light-blue);">
                                <li>
                                    <button class="dropdown-item text-white" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                        <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item text-white" onclick="deleteUser({{ $user->id }})">
                                        <i class="bi bi-trash me-2 text-danger"></i> Hapus
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row g-2 mb-3" style="color: var(--text-color);">
                        <div class="col-12">
                            <small class="text-muted d-block">Email</small>
                            <span class="text-break"><i class="bi bi-envelope me-2"></i>{{ $user->email }}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Nama Lengkap</small>
                            <span class="text-truncate d-block"><i class="bi bi-person me-2"></i>{{ $user->full_name ?? '-' }}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Telepon</small>
                            <span><i class="bi bi-telephone me-2"></i>{{ $user->phone ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-search fs-1 d-block mb-3"></i>
                Tidak ada pengguna ditemukan.
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
</div> 
{{-- !!! END OF CONTAINER FLUID !!! --}}


{{-- MODALS AREA (DI LUAR CONTAINER) --}}
{{-- PENTING: Letakkan modal di sini agar z-index tidak tertutup backdrop --}}

<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
            <div class="modal-header" style="border-bottom: 1px solid var(--light-blue);">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="full_name" style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" class="form-control" name="phone" style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--light-blue);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitAddUser()">Simpan</button>
            </div>
        </div>
    </div>
</div>

@foreach($users as $user)
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
            <div class="modal-header" style="border-bottom: 1px solid var(--light-blue);">
                <h5 class="modal-title">Edit: {{ $user->username }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm{{ $user->id }}">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="{{ $user->username }}" required style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="full_name" value="{{ $user->full_name }}" style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru <small class="text-muted">(Opsional)</small></label>
                        <input type="password" class="form-control" name="password" placeholder="Biarkan kosong jika tetap" style="background: var(--dark-blue); border: 1px solid var(--light-blue); color: var(--text-color);">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--light-blue);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitEditUser({{ $user->id }})">Update</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    function submitAddUser() {
        alert('Fitur tambah user backend belum terhubung.');
    }

    function submitEditUser(id) {
        alert('Fitur edit user backend belum terhubung untuk ID: ' + id);
    }

    function deleteUser(id) {
        if (confirm('Yakin ingin menghapus user ini?')) {
            alert('Menghapus user ID: ' + id);
        }
    }
</script>

@endsection