@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Manajemen Users</h4>
                <p class="mb-0" style="color: var(--text-secondary);">Kelola akun pengguna sistem</p>
            </div>
            <a href="/admin/users/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah User
            </a>
        </div>

        <!-- Main Card -->
        <div class="card"
            style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
            <div class="card-body p-0">
                <!-- Card Header -->
                <div class="d-flex justify-content-between align-items-center border-bottom p-4"
                    style="border-color: var(--glass-border) !important;">
                    <div>
                        <h5 class="mb-1 text-white" style="color: var(--text-primary); font-weight: 600;">Daftar Users</h5>
                        <p class="small mb-0 text-white">Total: {{ count($user_array) }} users terdaftar</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm text-white">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <button class="btn btn-outline-secondary btn-sm text-white">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="table-responsive">
                    <table class="table-hover mb-0 table" style="color: var(--text-secondary);">
                        <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                            <tr>
                                <th class="border-0 px-4 py-3"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">
                                    <div class="d-flex align-items-center gap-2 text-black">
                                        <span>No</span>
                                    </div>
                                </th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">User</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Email</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Status</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Photo</th>
                                <th class="border-0 py-3 text-center text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user_array as $user)
                                <tr class="border-bottom"
                                    style="border-color: rgba(51, 65, 85, 0.3) !important; transition: var(--transition-fast);"
                                    onmouseover="this.style.background='rgba(99, 102, 241, 0.05)'"
                                    onmouseout="this.style.background='transparent'">
                                    <!-- Number -->
                                    <td class="px-4 py-3">
                                        <span class="badge"
                                            style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;">
                                            #{{ $loop->index + 1 }}
                                        </span>
                                    </td>

                                    <!-- User Info -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; background: var(--primary-bg); color: var(--text-primary); font-weight: 600; font-size: 16px; border: 2px solid var(--glass-border);">
                                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold mb-0 text-black"
                                                    style="color: var(--text-primary); font-size: 14px;">
                                                    {{ $user->name }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="py-3">
                                        <div style="font-size: 13px;">
                                            <i class="fas fa-envelope text-muted me-2"></i>
                                            <span class="text-black">{{ $user->email }}</span>
                                        </div>
                                    </td>

                                    <!-- Status Toggle -->
                                    <td class="py-3">
                                        <form action="{{ route('update-status', $user->id) }}" method="POST"
                                            class="status-form" onchange="this.submit()">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-flex align-items-center gap-2">
                                                <label class="mb-0" style="cursor: pointer;">
                                                    <input type="radio" name="is_active" value="1"
                                                        {{ $user->is_active ? 'checked' : '' }}
                                                        class="form-check-input me-1" style="cursor: pointer;">
                                                    <span class="badge bg-success"
                                                        style="font-size: 11px; padding: 5px 10px;">
                                                        <i class="fas fa-check-circle me-1"></i>Active
                                                    </span>
                                                </label>
                                                <label class="mb-0" style="cursor: pointer;">
                                                    <input type="radio" name="is_active" value="0"
                                                        {{ !$user->is_active ? 'checked' : '' }}
                                                        class="form-check-input me-1" style="cursor: pointer;">
                                                    <span class="badge bg-secondary"
                                                        style="font-size: 11px; padding: 5px 10px;">
                                                        <i class="fas fa-times-circle me-1"></i>Inactive
                                                    </span>
                                                </label>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        @if ($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Gambar User"
                                                style="max-width: 100px; max-height: 100px;">
                                        @else
                                            No Image
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="/admin/users/{{ $user->id }}/edit"
                                                class="btn btn-outline-primary btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;" title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;" title="Hapus User"
                                                onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center">
                                        <div style="color: var(--text-light);">
                                            <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                                            <h6 style="color: var(--text-secondary);">Belum ada data user</h6>
                                            <p class="mb-3">Mulai dengan menambahkan user pertama</p>
                                            <a href="/admin/users/create" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-2"></i>Tambah User
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (method_exists($user_array, 'links'))
                    <div class="border-top p-3" style="border-color: var(--glass-border) !important;">
                        {{ $user_array->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: var(--dark-card); border: 1px solid var(--glass-border);">
                <div class="modal-header" style="border-color: var(--glass-border);">
                    <h5 class="modal-title" style="color: var(--text-primary);">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="filter: invert(1);"></button>
                </div>
                <div class="modal-body" style="color: var(--text-secondary);">
                    <p>Apakah Anda yakin ingin menghapus user:</p>
                    <div class="mb-3 rounded p-3"
                        style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                        <strong id="deleteName" style="color: var(--text-primary);"></strong>
                        <br>
                        <small class="text-muted" id="deleteEmail"></small>
                    </div>
                    <p class="text-warning small mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tindakan ini tidak dapat dibatalkan. Semua data yang terkait dengan user ini akan terhapus.
                    </p>
                </div>
                <div class="modal-footer" style="border-color: var(--glass-border);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, userName, userEmail) {
            document.getElementById('deleteName').textContent = userName;
            document.getElementById('deleteEmail').textContent = userEmail;
            document.getElementById('deleteForm').action = `/admin/users/${id}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Add loading state to status forms
        document.querySelectorAll('.status-form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;
                }
            });
        });
    </script>
@endsection
