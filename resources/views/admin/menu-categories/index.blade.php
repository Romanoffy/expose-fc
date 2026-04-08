@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Master Kategori Event</h4>
                <p class="mb-0 text-white" style="color: var(--text-secondary);">Kelola kegiatan/event untuk setiap kategori kompetisi</p>
            </div>
            <a href="/admin/menu-categories/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Event
            </a>
        </div>

        <!-- Main Card -->
        <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;">
            <div class="card-body p-0">
                <!-- Card Header -->
                <div class="d-flex justify-content-between align-items-center border-bottom p-4" style="border-color: var(--glass-border) !important;">
                    <div>
                        <h5 class="mb-1 text-white">Daftar Event</h5>
                        <p class="small mb-0 text-white">
                            Total: {{ $menuCategories->total() }} event
                            @if ($search || $selectedCategory)
                                <span class="badge bg-info ms-2">
                                    <i class="fas fa-filter me-1"></i>Filtered
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                            <tr>
                                <th class="border-0 px-4 py-3 text-black" style="font-weight: 600; font-size: 13px;">ID</th>
                                <th class="border-0 py-3 text-black" style="font-weight: 600; font-size: 13px;">Event</th>
                                <th class="border-0 py-3 text-black" style="font-weight: 600; font-size: 13px;">Kategori</th>
                                <th class="border-0 py-3 text-center text-black" style="font-weight: 600; font-size: 13px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menuCategories as $item)
                                <tr class="border-bottom" style="border-color: rgba(51, 65, 85, 0.3) !important;">
                                    <!-- ID -->
                                    <td class="px-4 py-3">
                                        <span class="badge" style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px;">
                                            #{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>

                                    <!-- Event Info -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px; background: var(--primary-bg); color: var(--text-primary); font-weight: 600;">
                                                <i class="fas fa-futbol"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-black" style="font-size: 14px;">
                                                    {{ $item->event_name }}
                                                </h6>
                                                @if ($item->description)
                                                    <small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category -->
                                    <td class="py-3">
                                        @php
                                            $badgeClass = [
                                                'internal' => 'bg-primary',
                                                'external' => 'bg-success',
                                                'friendly' => 'bg-warning',
                                            ][$item->category] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}" style="font-size: 12px; padding: 6px 12px;">
                                            <i class="fas fa-layer-group me-1"></i>{{ $item->category_label }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="/admin/menu-categories/{{ $item->id }}/edit"
                                               class="btn btn-outline-primary btn-sm"
                                               title="Edit Event">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="confirmDelete({{ $item->id }}, '{{ $item->event_name }}')"
                                                    title="Hapus Event">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div style="color: var(--text-light);">
                                            <i class="fas fa-futbol fa-3x mb-3 opacity-50"></i>
                                            <h6 style="color: var(--text-secondary);">Belum ada event</h6>
                                            <p class="mb-3 text-white">Mulai dengan menambahkan event baru</p>
                                            <a href="/admin/menu-categories/create" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-2"></i>Tambah Event
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($menuCategories->hasPages())
                    <div class="border-top p-3" style="border-color: var(--glass-border) !important;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-white">
                                Menampilkan {{ $menuCategories->firstItem() }} - {{ $menuCategories->lastItem() }} dari
                                {{ $menuCategories->total() }} event
                            </div>
                            <div>
                                {{ $menuCategories->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: var(--dark-card); border: 1px solid var(--glass-border);">
                <div class="modal-header" style="border-color: var(--glass-border);">
                    <h5 class="modal-title" style="color: var(--text-primary);">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body" style="color: var(--text-secondary);">
                    <p class="text-white">Apakah Anda yakin ingin menghapus event:</p>
                    <div class="p-3 mb-3 rounded" style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                        <strong id="deleteEventName" style="color: var(--text-primary);"></strong>
                    </div>
                    <div class="alert alert-warning mb-0" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                </div>
                <div class="modal-footer" style="border-color: var(--glass-border);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, eventName) {
            document.getElementById('deleteEventName').textContent = eventName;
            document.getElementById('deleteForm').action = `/admin/menu-categories/${id}`;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Notifications
        @if (session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.innerHTML = `
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} fa-lg"></i>
                    <span>${message}</span>
                    <button class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()" style="filter: invert(1);"></button>
                </div>
            `;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10001;
                background: ${type === 'success' ? '#10b981' : '#ef4444'};
                color: white;
                padding: 16px 20px;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.3);
                animation: slideInRight 0.3s ease;
                max-width: 400px;
                font-size: 14px;
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease forwards';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }
    </script>

    <style>
        #category option,
        #limit option {
            color: #000;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
@endsection