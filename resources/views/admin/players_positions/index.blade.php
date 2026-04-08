@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Manajemen Posisi Pemain</h4>
                <p
                    class="mb-0"
                    style="color: var(--text-secondary);"
                >Kelola posisi pemain Expose FC</p>
            </div>
            <a
                href="/admin/players_positions/create"
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
                        >Daftar Posisi Pemain</h5>
                        <p class="small mb-0 text-white">Total: {{ count($players_positions_array) }} posisi terdaftar</p>
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
                                        <span>ID</span>
                                    </div>
                                </th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Pemain</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Posisi</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Kategori</th>
                                <th
                                    class="border-0 py-3 text-center text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($players_positions_array as $playerposition)
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
                                            #{{ str_pad($playerposition->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>

                                    <!-- Player Info -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="position-relative">
                                                @if ($playerposition->player_photo)
                                                    <img
                                                        src="{{ asset('storage/' . $playerposition->player_photo) }}"
                                                        class="rounded-circle"
                                                        style="width: 48px; height: 48px; object-fit: cover; border: 2px solid var(--glass-border);"
                                                        alt="{{ $playerposition->player_name }}"
                                                    >
                                                @else
                                                    <div
                                                        class="rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px; background: var(--primary-bg); color: var(--text-primary); font-weight: 600; font-size: 16px; border: 2px solid var(--glass-border);"
                                                    >
                                                        {{ substr($playerposition->player_name ?? 'P', 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6
                                                    class="fw-semibold mb-0 text-black"
                                                    style="color: var(--text-primary); font-size: 14px;"
                                                >
                                                    {{ $playerposition->player_name ?? 'Unknown' }}
                                                </h6>
                                                <small class="text-muted">Player</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Position -->
                                    <td class="py-3">
                                        @php
                                            $positionName = $playerposition->position_name ?? '';
                                            $positionUpper = strtoupper($positionName);
                                            $badgeClass = 'bg-secondary';
                                            $icon = 'map-marker-alt';

                                            if (
                                                str_contains($positionUpper, 'GK') ||
                                                str_contains($positionUpper, 'KEEPER')
                                            ) {
                                                $badgeClass = 'bg-danger';
                                                $icon = 'hands';
                                            } elseif (
                                                str_contains($positionUpper, 'DEF') ||
                                                str_contains($positionUpper, 'BACK')
                                            ) {
                                                $badgeClass = 'bg-primary';
                                                $icon = 'shield-alt';
                                            } elseif (str_contains($positionUpper, 'MID')) {
                                                $badgeClass = 'bg-success';
                                                $icon = 'sync-alt';
                                            } elseif (
                                                str_contains($positionUpper, 'FOR') ||
                                                str_contains($positionUpper, 'STRIKER') ||
                                                str_contains($positionUpper, 'WING')
                                            ) {
                                                $badgeClass = 'bg-warning';
                                                $icon = 'futbol';
                                            }
                                        @endphp
                                        <span
                                            class="badge {{ $badgeClass }}"
                                            style="font-size: 12px; padding: 6px 12px;"
                                        >
                                            <i class="fas fa-{{ $icon }} me-1"></i>{{ $positionName }}
                                        </span>
                                    </td>

                                    <!-- Category -->
                                    <td class="py-3">
                                        <div style="font-size: 13px;">
                                            @php
                                                $category = 'Other';
                                                if (
                                                    str_contains($positionUpper, 'GK') ||
                                                    str_contains($positionUpper, 'KEEPER')
                                                ) {
                                                    $category = 'Goalkeeper';
                                                } elseif (
                                                    str_contains($positionUpper, 'DEF') ||
                                                    str_contains($positionUpper, 'BACK')
                                                ) {
                                                    $category = 'Defender';
                                                } elseif (str_contains($positionUpper, 'MID')) {
                                                    $category = 'Midfielder';
                                                } elseif (
                                                    str_contains($positionUpper, 'FOR') ||
                                                    str_contains($positionUpper, 'STRIKER') ||
                                                    str_contains($positionUpper, 'WING')
                                                ) {
                                                    $category = 'Forward';
                                                }
                                            @endphp
                                            <span class="text-muted">{{ $category }}</span>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a
                                                href="/admin/players_positions/{{ $playerposition->id }}/edit"
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
                                                onclick="confirmDelete({{ $playerposition->id }}, '{{ $playerposition->player_name }}', '{{ $playerposition->position_name }}')"
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
                                            <h6 style="color: var(--text-secondary);">Belum ada data posisi pemain</h6>
                                            <p class="mb-3">Mulai dengan menambahkan posisi pemain pertama</p>
                                            <a
                                                href="/admin/players_positions/create"
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
                @if (method_exists($players_positions_array, 'links'))
                    <div
                        class="border-top p-3"
                        style="border-color: var(--glass-border) !important;"
                    >
                        {{ $players_positions_array->links('pagination::bootstrap-5') }}
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
                        <br>
                        <small>sebagai</small>
                        <br>
                        <strong
                            id="deletePosition"
                            style="color: var(--primary-light);"
                        ></strong>
                    </div>
                    <p class="text-warning small mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tindakan ini tidak dapat dibatalkan.
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
        function confirmDelete(id, playerName, positionName) {
            document.getElementById('deleteName').textContent = playerName;
            document.getElementById('deletePosition').textContent = positionName;
            document.getElementById('deleteForm').action = `/admin/players_positions/${id}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection
