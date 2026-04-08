@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Manajemen Pemain</h4>
                <p
                    class="mb-0"
                    style="color: var(--text-secondary);"
                >Kelola data pemain Expose FC</p>
            </div>
            <a
                href="/admin/players/create"
                class="btn btn-primary"
            >
                <i class="fas fa-plus me-2"></i>Tambah Pemain
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
                        >Daftar Pemain</h5>
                        <p class="small mb-0 text-white">Total: {{ count($player_array) }} pemain terdaftar</p>
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
                                >Tim</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Tanggal Lahir</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >Jenis Kelamin</th>
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
                            @forelse($player_array as $player)
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
                                            #{{ str_pad($player->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>

                                    <!-- Player Info -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="position-relative">
                                                @if ($player->photo)
                                                    <img
                                                        src="{{ asset('storage/' . $player->photo) }}"
                                                        class="rounded-circle"
                                                        style="width: 48px; height: 48px; object-fit: cover; border: 2px solid var(--glass-border);"
                                                        alt="{{ $player->name }}"
                                                    >
                                                @else
                                                    <div
                                                        class="rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 48px; height: 48px; background: var(--primary-bg); color: var(--text-primary); font-weight: 600; font-size: 18px; border: 2px solid var(--glass-border);"
                                                    >
                                                        {{ substr($player->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div
                                                    class="position-absolute rounded-circle bottom-0 end-0"
                                                    style="width: 14px; height: 14px; background: {{ $player->status == 1 ? 'var(--success)' : 'var(--text-light)' }}; border: 2px solid var(--dark-card);"
                                                ></div>
                                            </div>
                                            <div>
                                                <h6
                                                    class="fw-semibold mb-0 text-black"
                                                    style="color: var(--text-primary); font-size: 14px;"
                                                >{{ $player->name }}</h6>
                                                <small class="text-muted">Player</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Team -->
                                    <td class="py-3">
                                        <div>
                                            <span
                                                class="badge"
                                                style="background: var(--info); color: white; font-size: 11px; padding: 4px 8px;"
                                            >
                                                <i class="fas fa-flag me-1"></i>{{ $player->team_name ?? 'No Team' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Birth Date -->
                                    <td class="py-3">
                                        <div style="font-size: 13px;">
                                            <i
                                                class="fas fa-calendar me-2"
                                                style="color: var(--text-light); font-size: 11px;"
                                            ></i>
                                            {{ \Carbon\Carbon::parse($player->birth_date)->locale('id')->translatedFormat('d M Y') }}
                                        </div>
                                    </td>

                                    <!-- Gender -->
                                    <td class="py-3">
                                        @if ($player->gender == 1)
                                            <span
                                                class="badge bg-info"
                                                style="font-size: 11px; padding: 4px 8px;"
                                            >
                                                <i class="fas fa-mars me-1"></i>Laki-laki
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-danger"
                                                style="font-size: 11px; padding: 4px 8px;"
                                            >
                                                <i class="fas fa-venus me-1"></i>Perempuan
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3">
                                        @if ($player->status == 1)
                                            <span
                                                class="badge bg-success"
                                                style="font-size: 11px; padding: 4px 8px;"
                                            >
                                                <i class="fas fa-check-circle me-1"></i>Active
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-secondary"
                                                style="font-size: 11px; padding: 4px 8px;"
                                            >
                                                <i class="fas fa-times-circle me-1"></i>Non Active
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a
                                                href="/admin/players/{{ $player->id }}/edit"
                                                class="btn btn-outline-primary btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;"
                                                title="Edit Pemain"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;"
                                                title="Hapus Pemain"
                                                onclick="confirmDelete({{ $player->id }}, '{{ $player->name }}')"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="7"
                                        class="py-5 text-center"
                                    >
                                        <div style="color: var(--text-light);">
                                            <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                                            <h6 style="color: var(--text-secondary);">Belum ada data pemain</h6>
                                            <p class="mb-3">Mulai dengan menambahkan pemain pertama</p>
                                            <a
                                                href="/admin/players/create"
                                                class="btn btn-primary btn-sm"
                                            >
                                                <i class="fas fa-plus me-2"></i>Tambah Pemain
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (method_exists($player_array, 'links'))
                    <div
                        class="border-top p-3"
                        style="border-color: var(--glass-border) !important;"
                    >
                        {{ $player_array->links('pagination::bootstrap-5') }}
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
                    <p>Apakah Anda yakin ingin menghapus pemain <strong
                            id="deleteName"
                            style="color: var(--text-primary);"
                        ></strong>?</p>
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
        function confirmDelete(id, name) {
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/players/${id}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection
