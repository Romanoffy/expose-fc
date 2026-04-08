@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Manajemen Kompetisi</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Kelola data kompetisi olahraga</p>
            </div>
            <a
                href="/admin/competitions/create"
                class="btn btn-primary"
            >
                <i class="fas fa-plus me-2"></i>Tambah Kompetisi
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
                        >Daftar Kompetisi</h5>
                        <p class="small mb-0 text-white">
                            Total: {{ $competitions_array->total() }} kompetisi
                            @if ($search || $selectedYear || $selectedCategory)
                                <span class="badge bg-info ms-2">
                                    <i class="fas fa-filter me-1"></i>Filtered
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button
                            class="btn btn-outline-secondary btn-sm text-white"
                            onclick="exportData()"
                        >
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
                                    class="border-0 px-4 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >
                                    <div class="d-flex align-items-center gap-2">
                                        <span>ID</span>
                                    </div>
                                </th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Kompetisi</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Tahun</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Kategori</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Event</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Periode</th>
                                <th
                                    class="border-0 py-3 text-center text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($competitions_array as $competition)
                                <tr
                                    class="border-bottom"
                                    style="border-color: rgba(51, 65, 85, 0.3) !important; transition: var(--transition-fast);"
                                    onmouseover="this.style.background='rgba(99, 102, 241, 0.05)'"
                                    onmouseout="this.style.background='transparent'"
                                >
                                    <!-- ID -->
                                    <td class="px-4 py-3">
                                        <span
                                            class="badge"
                                            style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;"
                                        >
                                            #{{ str_pad($competition->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>

                                    <!-- Competition Info -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div
                                                class="rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; background: var(--primary-bg); color: var(--text-primary); font-weight: 600; font-size: 16px; border: 2px solid var(--glass-border);"
                                            >
                                                <i class="fas fa-trophy"></i>
                                            </div>
                                            <div>
                                                <h6
                                                    class="fw-semibold mb-0 text-black"
                                                    style="color: var(--text-primary); font-size: 14px;"
                                                >
                                                    {{ $competition->name }}
                                                </h6>
                                                <small
                                                    class="text-muted">{{ Str::limit($competition->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Year -->
                                    <td class="py-3">
                                        <span
                                            class="badge bg-info"
                                            style="font-size: 12px; padding: 6px 12px;"
                                        >
                                            <i class="fas fa-calendar me-1"></i>{{ $competition->year ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- Category -->
                                    <td class="py-3">
                                        @if (isset($competition->category))
                                            @php
                                                $categoryColors = [
                                                    'internal' => 'bg-primary',
                                                    'external' => 'bg-success',
                                                    'friendly' => 'bg-warning',
                                                ];
                                                $categoryBadge =
                                                    $categoryColors[$competition->category] ?? 'bg-secondary';
                                            @endphp
                                            <span
                                                class="badge {{ $categoryBadge }}"
                                                style="font-size: 12px; padding: 6px 12px;"
                                            >
                                                <i class="fas fa-layer-group me-1"></i>{{ ucfirst($competition->category) }}
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-secondary"
                                                style="font-size: 12px; padding: 6px 12px;"
                                            >-</span>
                                        @endif
                                    </td>

                                    <!-- Event Type -->
                                    <td class="py-3">
                                        @if (isset($competition->event_type))
                                            <span
                                                class="badge bg-success"
                                                style="font-size: 11px; padding: 5px 10px;"
                                            >
                                                <i class="fas fa-futbol me-1"></i>{{ $competition->event_type }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <!-- Period -->
                                    <td class="py-3">
                                        <div
                                            class="text-black"
                                            style="font-size: 13px;"
                                        >
                                            <div class="mb-1">
                                                <i class="fas fa-calendar-start text-success me-1"></i>
                                                {{ \Carbon\Carbon::parse($competition->tanggal_mulai)->format('d M Y') }}
                                            </div>
                                            <div>
                                                <i class="fas fa-calendar-check text-danger me-1"></i>
                                                {{ \Carbon\Carbon::parse($competition->tanggal_selesai)->format('d M Y') }}
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a
                                                href="/admin/competitions/{{ $competition->id }}/edit"
                                                class="btn btn-outline-primary btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;"
                                                title="Edit Kompetisi"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;"
                                                title="Hapus Kompetisi"
                                                onclick="confirmDelete({{ $competition->id }}, '{{ $competition->name }}')"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="8"
                                        class="py-5 text-center"
                                    >
                                        <div style="color: var(--text-light);">
                                            <i class="fas fa-trophy fa-3x mb-3 opacity-50"></i>
                                            <h6 style="color: var(--text-secondary);">
                                                @if ($search || $selectedYear || $selectedCategory)
                                                    Tidak ada kompetisi yang sesuai dengan filter
                                                @else
                                                    Belum ada kompetisi
                                                @endif
                                            </h6>
                                            <p class="mb-3 text-white">
                                                @if ($search || $selectedYear || $selectedCategory)
                                                    Coba ubah filter pencarian Anda
                                                @else
                                                    Mulai dengan menambahkan kompetisi baru
                                                @endif
                                            </p>
                                            @if (!$search && !$selectedYear && !$selectedCategory)
                                                <a
                                                    href="/admin/competitions/create"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    <i class="fas fa-plus me-2"></i>Tambah Kompetisi
                                                </a>
                                            @else
                                                <a
                                                    href="/admin/competitions"
                                                    class="btn btn-secondary btn-sm"
                                                >
                                                    <i class="fas fa-redo me-2"></i>Reset Filter
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($competitions_array->hasPages())
                    <div
                        class="border-top p-3"
                        style="border-color: var(--glass-border) !important;"
                    >
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-white">
                                Menampilkan {{ $competitions_array->firstItem() }} - {{ $competitions_array->lastItem() }}
                                dari {{ $competitions_array->total() }} kompetisi
                            </div>
                            <div>
                                {{ $competitions_array->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
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
                    >
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Konfirmasi Hapus
                    </h5>
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
                    <p class="text-white">Apakah Anda yakin ingin menghapus kompetisi:</p>
                    <div
                        class="mb-3 rounded p-3"
                        style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                    >
                        <strong
                            id="deleteCompetition"
                            style="color: var(--text-primary);"
                        ></strong>
                    </div>
                    <div
                        class="alert alert-warning mb-0"
                        style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);"
                    >
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data
                        terkait.
                    </div>
                </div>
                <div
                    class="modal-footer"
                    style="border-color: var(--glass-border);"
                >
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
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
                        >
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, competitionName) {
            document.getElementById('deleteCompetition').textContent = competitionName;
            document.getElementById('deleteForm').action = `/admin/competitions/${id}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        function exportData() {
            // Implementasi export (CSV/Excel)
            alert('Fitur export akan segera hadir!');
        }

        // Auto-submit filter on change
        document.querySelectorAll(
            'select[name="year"], select[name="category"], select[name="limit"]').forEach(
            select => {
                select.addEventListener('change', function() {
                    document.getElementById('filterForm').submit();
                });
            });

        // Success/Error notification
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
