@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Goal Pertandingan</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Kelola goal untuk pertandingan ini</p>
            </div>
            <div class="d-flex gap-2">
                <a
                    href="{{ route('match_goals.index') }}"
                    class="btn btn-secondary"
                >
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a
                    href="{{ route('match_goals.create', ['match_id' => $match->id]) }}"
                    class="btn btn-primary"
                >
                    <i class="fas fa-plus me-2"></i>Tambah Goal
                </a>
            </div>
        </div>

        <!-- Match Info Card -->
        <div
            class="card mb-4"
            style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
        >
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-5 text-center">
                        <img
                            src="{{ asset('storage/' . $match->team_logo_1) }}"
                            alt="{{ $match->teamname_1 }}"
                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 3px solid var(--glass-border);"
                        >
                        <h5 class="mb-0 mt-3 text-white">{{ $match->teamname_1 }}</h5>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="mb-2">
                            <span class="badge bg-info">
                                <i
                                    class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($match->date)->format('d M Y') }}
                            </span>
                        </div>
                        <h2 class="fw-bold mb-2 text-white">{{ $match->score_team1 ?? 0 }} - {{ $match->score_team2 ?? 0 }}
                        </h2>
                        <small class="text-white">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $match->venue->name ?? '-' }}
                        </small>
                    </div>
                    <div class="col-md-5 text-center">
                        <img
                            src="{{ asset('storage/' . $match->team_logo_2) }}"
                            alt="{{ $match->teamname_2 }}"
                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 3px solid var(--glass-border);"
                        >
                        <h5 class="mb-0 mt-3 text-white">{{ $match->teamname_2 }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Goals List -->
        <div
            class="card"
            style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
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
                            style="font-weight: 600;"
                        >Daftar Goal</h5>
                        <p class="small mb-0 text-white">Total: {{ $goals->count() }} goal</p>
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
                                    style="font-weight: 600; font-size: 13px;"
                                >Menit</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Pemain</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Tim</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Jenis Goal</th>
                                <th
                                    class="border-0 py-3 text-center text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($goals as $goal)
                                <tr
                                    class="border-bottom"
                                    style="border-color: rgba(51, 65, 85, 0.3) !important;"
                                    onmouseover="this.style.background='rgba(99, 102, 241, 0.05)'"
                                    onmouseout="this.style.background='transparent'"
                                >

                                    <!-- Minute -->
                                    <td class="px-4 py-3">
                                        <span
                                            class="badge bg-success"
                                            style="font-size: 14px; padding: 8px 12px;"
                                        >
                                            <i class="fas fa-clock me-1"></i>{{ $goal->minute }}'
                                        </span>
                                    </td>

                                    <!-- Player -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div
                                                class="rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 36px; height: 36px; background: var(--primary-bg); color: var(--text-primary); font-weight: 600; font-size: 14px; border: 2px solid var(--glass-border);"
                                            >
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span class="fw-semibold text-black">{{ $goal->player->name ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <!-- Team -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($goal->team)
                                                <img
                                                    src="{{ asset('storage/' . $goal->team->logo) }}"
                                                    alt="{{ $goal->team->name }}"
                                                    style="width: 28px; height: 28px; object-fit: cover; border-radius: 50%;"
                                                >
                                                <span class="text-black">{{ $goal->team->name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Goal Type -->
                                    <td class="py-3">
                                        @php
                                            $goalTypeColors = [
                                                'regular' => 'bg-primary',
                                                'penalty' => 'bg-warning',
                                                'own_goal' => 'bg-danger',
                                            ];
                                            $goalTypeLabels = [
                                                'regular' => 'Regular',
                                                'penalty' => 'Penalty',
                                                'own_goal' => 'Own Goal',
                                            ];
                                            $goalTypeBadge = $goalTypeColors[$goal->goal_type] ?? 'bg-secondary';
                                            $goalTypeLabel = $goalTypeLabels[$goal->goal_type] ?? 'Unknown';
                                        @endphp
                                        <span
                                            class="badge {{ $goalTypeBadge }}"
                                            style="font-size: 12px; padding: 6px 12px;"
                                        >
                                            {{ $goalTypeLabel }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a
                                                href="{{ route('match_goals.edit', $goal->id) }}"
                                                class="btn btn-outline-primary btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;"
                                                title="Edit Goal"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger btn-sm"
                                                style="padding: 6px 10px; font-size: 12px;"
                                                title="Hapus Goal"
                                                onclick="confirmDelete({{ $goal->id }}, '{{ $goal->player->name ?? 'Goal' }} - {{ $goal->minute }}\'')"
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
                                            <i class="fas fa-futbol fa-3x mb-3 opacity-50"></i>
                                            <h6 style="color: var(--text-secondary);">Belum ada goal yang tercatat</h6>
                                            <p class="mb-3 text-black">Mulai dengan menambahkan goal pertama</p>
                                            <a
                                                href="{{ route('match_goals.create', ['match_id' => $match->id]) }}"
                                                class="btn btn-primary btn-sm"
                                            >
                                                <i class="fas fa-plus me-2"></i>Tambah Goal
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
                    <p class="text-white">Apakah Anda yakin ingin menghapus goal:</p>
                    <div
                        class="mb-3 rounded p-3"
                        style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                    >
                        <strong
                            id="deleteGoal"
                            style="color: var(--text-primary);"
                        ></strong>
                    </div>
                    <div
                        class="alert alert-warning mb-0"
                        style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);"
                    >
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan.
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
        function confirmDelete(id, goalInfo) {
            document.getElementById('deleteGoal').textContent = goalInfo;
            document.getElementById('deleteForm').action = `/admin/match_goals/${id}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

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
