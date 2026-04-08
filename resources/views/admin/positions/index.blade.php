@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Manajemen Posisi</h4>
                <p
                    class="mb-0"
                    style="color: var(--text-secondary);"
                >Kelola posisi pemain Expose FC</p>
            </div>
            <a
                href="/admin/positions/create"
                class="btn btn-primary"
            >
                <i class="fas fa-plus me-2"></i>Tambah Posisi
            </a>
        </div>

        <!-- Main Card -->
        <div
            class="card"
            style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
        >
            <div class="card-body p-0">
                <!-- Card Header -->
                <div
                    class="d-flex justify-content-between align-items-center border-bottom p-4"
                    style="border-color: var(--glass-border) !important;"
                >
                    <div>
                        <h5
                            class="mb-1 text-white"
                            style="color: var(--text-primary); font-weight: 600;"
                        >Daftar Posisi</h5>
                        <p class="small mb-0 text-white">Total: {{ count($position_array) }} posisi terdaftar</p>
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
                    <table
                        class="table-hover mb-0 table"
                        style="color: var(--text-secondary);"
                    >
                        <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                            <tr>
                                <th
                                    class="border-0 px-4 py-3"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >
                                    <div class="d-flex align-items-center gap-2 text-black">
                                        <span>No</span>
                                    </div>
                                </th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Nama Posisi</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Kategori</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Status</th>
                                <th
                                    class="border-0 py-3 text-center text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($position_array as $position)
                                <tr
                                    class="border-bottom"
                                    style="border-color: rgba(51, 65, 85, 0.3) !important; transition: var(--transition-fast);"
                                    onmouseover="this.style.background='rgba(99, 102, 241, 0.05)'"
                                    onmouseout="this.style.background='transparent'"
                                >
                                    <!-- Number -->
                                    <td class="px-4 py-3">
                                        <span
                                            class="badge"
                                            style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;"
                                        >
                                            #{{ $loop->index + 1 }}
                                        </span>
                                    </td>

                                    <!-- Position Name -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @php
                                                $positionName = $position->name ?? '';
                                                $positionUpper = strtoupper($positionName);
                                                $iconClass = 'fa-map-marker-alt';
                                                $iconBg = 'rgba(99, 102, 241, 0.1)';
                                                $iconColor = 'var(--primary-light)';

                                                if (
                                                    str_contains($positionUpper, 'GK') ||
                                                    str_contains($positionUpper, 'KEEPER')
                                                ) {
                                                    $iconClass = 'fa-hands';
                                                    $iconBg = 'rgba(239, 68, 68, 0.1)';
                                                    $iconColor = '#ef4444';
                                                } elseif (
                                                    str_contains($positionUpper, 'DEF') ||
                                                    str_contains($positionUpper, 'BACK')
                                                ) {
                                                    $iconClass = 'fa-shield-alt';
                                                    $iconBg = 'rgba(59, 130, 246, 0.1)';
                                                    $iconColor = '#3b82f6';
                                                } elseif (str_contains($positionUpper, 'MID')) {
                                                    $iconClass = 'fa-sync-alt';
                                                    $iconBg = 'rgba(16, 185, 129, 0.1)';
                                                    $iconColor = '#10b981';
                                                } elseif (
                                                    str_contains($positionUpper, 'FOR') ||
                                                    str_contains($positionUpper, 'STRIKER') ||
                                                    str_contains($positionUpper, 'WING')
                                                ) {
                                                    $iconClass = 'fa-futbol';
                                                    $iconBg = 'rgba(245, 158, 11, 0.1)';
                                                    $iconColor = '#f59e0b';
                                                }
                                            @endphp
                                            <div
                                                class="rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; background: {{ $iconBg }}; border: 2px solid var(--glass-border);"
                                            >
                                                <i
                                                    class="fas {{ $iconClass }}"
                                                    style="color: {{ $iconColor }}; font-size: 16px;"
                                                ></i>
                                            </div>
                                            <div>
                                                <h6
                                                    class="fw-semibold mb-0 text-black"
                                                    style="color: var(--text-primary); font-size: 14px;"
                                                >
                                                    {{ $positionName }}
                                                </h6>
                                                <small class="text-muted">Position</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category -->
                                    <td class="py-3">
                                        @php
                                            $category = 'Other';
                                            $badgeClass = 'bg-secondary';

                                            if (
                                                str_contains($positionUpper, 'GK') ||
                                                str_contains($positionUpper, 'KEEPER')
                                            ) {
                                                $category = 'Goalkeeper';
                                                $badgeClass = 'bg-danger';
                                            } elseif (
                                                str_contains($positionUpper, 'DEF') ||
                                                str_contains($positionUpper, 'BACK')
                                            ) {
                                                $category = 'Defender';
                                                $badgeClass = 'bg-primary';
                                            } elseif (str_contains($positionUpper, 'MID')) {
                                                $category = 'Midfielder';
                                                $badgeClass = 'bg-success';
                                            } elseif (
                                                str_contains($positionUpper, 'FOR') ||
                                                str_contains($positionUpper, 'STRIKER') ||
                                                str_contains($positionUpper, 'WING')
                                            ) {
                                                $category = 'Forward';
                                                $badgeClass = 'bg-warning';
                                            }
                                        @endphp
                                        <span
                                            class="badge {{ $badgeClass }}"
                                            style="font-size: 12px; padding: 6px 12px;"
                                        >
                                            <i class="fas {{ $iconClass }} me-1"></i>{{ $category }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3">
                                        <span
                                            class="badge bg-success"
                                            style="font-size: 11px; padding: 5px 10px;"
                                        >
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a
                                                href="/admin/positions/{{ $position->id }}/edit"
                                                class="btn btn-outline-primary btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;"
                                                title="Edit Posisi"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;"
                                                title="Hapus Posisi"
                                                onclick="confirmDelete({{ $position->id }}, '{{ $position->name }}')"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="5"
                                        class="py-5 text-center"
                                    >
                                        <div style="color: var(--text-light);">
                                            <i class="fas fa-map-marker-alt fa-3x mb-3 opacity-50"></i>
                                            <h6 style="color: var(--text-secondary);">Belum ada data posisi</h6>
                                            <p class="mb-3">Mulai dengan menambahkan posisi pertama</p>
                                            <a
                                                href="/admin/positions/create"
                                                class="btn btn-primary btn-sm"
                                            >
                                                <i class="fas fa-plus me-2"></i>Tambah Posisi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (method_exists($position_array, 'links'))
                    <div
                        class="border-top p-3"
                        style="border-color: var(--glass-border) !important;"
                    >
                        {{ $position_array->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div
                class="modal-content"
                style="background: var(--dark-card); border: 1px solid var(--glass-border);"
            >
                <div
                    class="modal-header"
                    style="border-color: var(--glass-border);"
                >
                    <h5
                        class="modal-title"
                        style="color: var(--text-primary);"
                    >Konfirmasi Hapus</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        style="filter: invert(1);"
                    ></button>
                </div>
                <div
                    class="modal-body"
                    style="color: var(--text-secondary);"
                >
                    <p>Apakah Anda yakin ingin menghapus posisi:</p>
                    <div
                        class="mb-3 rounded p-3"
                        style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                    >
                        <strong
                            id="deleteName"
                            style="color: var(--text-primary);"
                        ></strong>
                    </div>
                    <p class="text-warning small mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tindakan ini tidak dapat dibatalkan. Semua data yang terkait dengan posisi ini akan terhapus.
                    </p>
                </div>
                <div
                    class="modal-footer"
                    style="border-color: var(--glass-border);"
                >
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >Batal</button>
                    <form
                        id="deleteForm"
                        method="POST"
                        style="display: inline;"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="btn btn-danger"
                        >Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, positionName) {
            document.getElementById('deleteName').textContent = positionName;
            document.getElementById('deleteForm').action = `/admin/positions/${id}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection
