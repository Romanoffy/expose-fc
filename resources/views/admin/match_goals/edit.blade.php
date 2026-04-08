@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .is-invalid {
            border-color: #ef4444 !important;
        }

        #team_id option,
        #player_id option,
        #goal_type option {
            color: #000;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Edit Goal</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Ubah data goal pertandingan</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route('match_goals.index') }}"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-futbol me-1"></i>Match Goals
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route('match_goals.index', ['match_id' => $match->id]) }}"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            {{ $match->teamname_1 }} vs {{ $match->teamname_2 }}
                        </a>
                    </li>
                    <li
                        class="breadcrumb-item active"
                        style="color: var(--text-primary);"
                    >Edit</li>
                </ol>
            </nav>
        </div>

        <!-- Alert Messages -->
        @if (session('error'))
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>
            </div>
        @endif

        @if ($errors->any())
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Validasi Gagal!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Match Info Card -->
            <div class="col-lg-4">
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;"
                    >
                        <h6 class="mb-0 text-white"><i class="fas fa-info-circle me-2"></i>Info Pertandingan</h6>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <span class="badge bg-info">
                                <i
                                    class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($match->date)->format('d M Y, H:i') }}
                            </span>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-5">
                                <img
                                    src="{{ asset('storage/' . $match->team_logo_1) }}"
                                    alt="{{ $match->teamname_1 }}"
                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 3px solid var(--glass-border);"
                                >
                                <h6 class="mb-0 mt-2 text-white">{{ $match->teamname_1 }}</h6>
                            </div>
                            <div class="col-2">
                                <h4 class="fw-bold mb-0 text-white">VS</h4>
                            </div>
                            <div class="col-5">
                                <img
                                    src="{{ asset('storage/' . $match->team_logo_2) }}"
                                    alt="{{ $match->teamname_2 }}"
                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 3px solid var(--glass-border);"
                                >
                                <h6 class="mb-0 mt-2 text-white">{{ $match->teamname_2 }}</h6>
                            </div>
                        </div>

                        <div class="mb-2">
                            <h3 class="fw-bold text-white">{{ $match->score_team1 ?? 0 }} - {{ $match->score_team2 ?? 0 }}
                            </h3>
                        </div>

                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $match->venue->name ?? '-' }}
                        </small>
                    </div>
                </div>

                <!-- Current Goal Info -->
                <div
                    class="card mt-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-futbol me-2"
                                style="color: var(--primary-light);"
                            ></i>Goal Saat Ini
                        </h6>
                        <div class="small text-white">
                            <div class="mb-2">
                                <strong>Pemain:</strong> {{ $goal->player->name ?? '-' }}
                            </div>
                            <div class="mb-2">
                                <strong>Tim:</strong> {{ $goal->team->name ?? '-' }}
                            </div>
                            <div class="mb-2">
                                <strong>Menit:</strong> {{ $goal->minute }}'
                            </div>
                            <div>
                                <strong>Jenis:</strong>
                                @php
                                    $goalTypeLabels = [
                                        'regular' => 'Regular',
                                        'penalty' => 'Penalty',
                                        'own_goal' => 'Own Goal',
                                    ];
                                @endphp
                                {{ $goalTypeLabels[$goal->goal_type] ?? 'Unknown' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Helper Tips -->
                <div
                    class="card mt-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-lightbulb me-2"
                                style="color: var(--warning);"
                            ></i>Tips
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-2">Pilih tim terlebih dahulu untuk melihat daftar pemain</li>
                            <li class="mb-2">Menit goal: 1-90 (waktu normal) atau 91-120 (perpanjangan waktu)</li>
                            <li class="mb-2"><strong>Regular:</strong> Goal biasa</li>
                            <li class="mb-2"><strong>Penalty:</strong> Goal dari titik penalti</li>
                            <li><strong>Own Goal:</strong> Gol bunuh diri</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <div class="col-lg-8">
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle p-2"
                                style="background: var(--primary-bg);"
                            >
                                <i
                                    class="fas fa-edit"
                                    style="color: var(--primary-light); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Edit Informasi Goal</h5>
                                <small class="text-white">Ubah detail goal</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="{{ route('match_goals.update', $goal->id) }}"
                            method="POST"
                            id="goalForm"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Team Selection -->
                                <div class="col-md-12">
                                    <label
                                        for="team_id"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-users me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Tim yang Mencetak Goal
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="team_id"
                                        id="team_id"
                                        class="form-control @error('team_id') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Tim</option>
                                        <option
                                            value="{{ $match->team_id_1 }}"
                                            {{ old('team_id', $goal->team_id) == $match->team_id_1 ? 'selected' : '' }}
                                        >
                                            {{ $match->teamname_1 }}
                                        </option>
                                        <option
                                            value="{{ $match->team_id_2 }}"
                                            {{ old('team_id', $goal->team_id) == $match->team_id_2 ? 'selected' : '' }}
                                        >
                                            {{ $match->teamname_2 }}
                                        </option>
                                    </select>
                                    @error('team_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Player Selection -->
                                <div class="col-md-12">
                                    <label
                                        for="player_id"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-user me-2"
                                            style="color: var(--success);"
                                        ></i>
                                        Pemain Pencetak Goal
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="player_id"
                                        id="player_id"
                                        class="form-control @error('player_id') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Pemain</option>
                                    </select>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Pemain akan muncul setelah memilih tim
                                    </small>
                                    @error('player_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Minute -->
                                <div class="col-md-6">
                                    <label
                                        for="minute"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-clock me-2"
                                            style="color: var(--info);"
                                        ></i>
                                        Menit Goal
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="minute"
                                        id="minute"
                                        value="{{ old('minute', $goal->minute) }}"
                                        class="form-control @error('minute') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        placeholder="Contoh: 45"
                                        min="1"
                                        max="120"
                                        required
                                    >
                                    <small class="text-muted d-block mt-1">Menit 1-120</small>
                                    @error('minute')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Goal Type -->
                                <div class="col-md-6">
                                    <label
                                        for="goal_type"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-futbol me-2"
                                            style="color: var(--warning);"
                                        ></i>
                                        Jenis Goal
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="goal_type"
                                        id="goal_type"
                                        class="form-control @error('goal_type') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Jenis Goal</option>
                                        <option
                                            value="regular"
                                            {{ old('goal_type', $goal->goal_type) == 'regular' ? 'selected' : '' }}
                                        >Regular</option>
                                        <option
                                            value="penalty"
                                            {{ old('goal_type', $goal->goal_type) == 'penalty' ? 'selected' : '' }}
                                        >Penalty</option>
                                        <option
                                            value="own_goal"
                                            {{ old('goal_type', $goal->goal_type) == 'own_goal' ? 'selected' : '' }}
                                        >Own Goal</option>
                                    </select>
                                    @error('goal_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="{{ route('match_goals.index', ['match_id' => $match->id]) }}"
                                    class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                >
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                    id="submitBtn"
                                >
                                    <i class="fas fa-save me-2"></i>Update Goal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const teamSelect = document.getElementById('team_id');
            const playerSelect = document.getElementById('player_id');
            const form = document.getElementById('goalForm');
            const submitBtn = document.getElementById('submitBtn');

            // Players data
            const team1Players = @json($team1Players);
            const team2Players = @json($team2Players);
            const match = @json($match);

            // IMPROVEMENT: Validate player belongs to selected team
            function validatePlayerTeam() {
                const selectedTeamId = teamSelect.value;
                const selectedPlayerId = playerSelect.value;

                if (!selectedTeamId || !selectedPlayerId) return true;

                let players = selectedTeamId == match.team_id_1 ? team1Players : team2Players;
                let playerExists = players.some(p => p.id == selectedPlayerId);

                if (!playerExists) {
                    showNotification('Pemain tidak termasuk dalam tim yang dipilih', 'error');
                    return false;
                }
                return true;
            }

            // Function to populate players based on selected team
            function populatePlayers(teamId, selectedPlayerId = null) {
                playerSelect.innerHTML = '<option value="">Pilih Pemain</option>';

                let players = [];
                if (teamId == match.team_id_1) {
                    players = team1Players;
                } else if (teamId == match.team_id_2) {
                    players = team2Players;
                }

                if (players.length > 0) {
                    playerSelect.disabled = false;
                    players.forEach(player => {
                        const option = document.createElement('option');
                        option.value = player.id;
                        option.textContent = `${player.name} (#${player.number || '-'})`;
                        if (selectedPlayerId && player.id == selectedPlayerId) {
                            option.selected = true;
                        }
                        playerSelect.appendChild(option);
                    });
                } else {
                    playerSelect.disabled = true;
                    playerSelect.innerHTML = '<option value="">Tidak ada pemain aktif</option>';
                }
            }

            // Update players when team changes
            teamSelect.addEventListener('change', function() {
                populatePlayers(this.value);
            });

            // Load players if old team value exists
            const oldTeamId = '{{ old('team_id', $goal->team_id ?? '') }}';
            const oldPlayerId = '{{ old('player_id', $goal->player_id ?? '') }}';

            if (oldTeamId) {
                populatePlayers(oldTeamId, oldPlayerId);
            }

            // Form validation
            form.addEventListener('submit', function(e) {
                const minute = document.getElementById('minute').value;

                // Validate minute range
                if (minute < 1 || minute > 120) {
                    e.preventDefault();
                    showNotification('Menit goal harus antara 1-120', 'error');
                    return;
                }

                // Validate player belongs to team
                if (!validatePlayerTeam()) {
                    e.preventDefault();
                    return;
                }

                // Check required fields
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
                    return;
                }

                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;
            });
        });
        // Tambahkan fungsi ini di dalam tag <script> sebelum closing tag
        // Letakkan setelah event listener form submit

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

        // Show notifications from session
        @if (session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif

        @if (session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif
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
