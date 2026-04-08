@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        select option {
            color: #000;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(20px);
                opacity: 0
            }

            to {
                transform: translateX(0);
                opacity: 1
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1
            }

            to {
                transform: translateX(20px);
                opacity: 0
            }
        }

        .auto-status-badge {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(16, 185, 129, 0.1));
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 10px;
            padding: 12px 16px;
            margin-top: 8px;
        }

        /* ERROR STATE */
        .is-invalid {
            border-color: #ef4444 !important;
            animation: shake 0.3s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1 text-white"
                    style="font-weight: 600;"
                >Tambah Pertandingan Baru</h4>
                <p class="mb-0 text-white">Lengkapi detail pertandingan berikut</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/matches"
                            class="text-white"
                            style="text-decoration: none;"
                        >
                            <i class="fas fa-futbol me-1"></i>Pertandingan
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-white">Tambah Baru</li>
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
                {{ session('error') }}
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
                <strong>Terdapat kesalahan:</strong>
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
            <!-- Main Form Column -->
            <div class="col-lg-8">
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border);"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle p-2"
                                style="background: var(--primary-bg);"
                            >
                                <i
                                    class="fas fa-calendar-plus"
                                    style="color: var(--primary-light); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0 text-white"
                                    style="font-weight: 600;"
                                >Informasi Pertandingan</h5>
                                <small class="text-white">Masukkan data lengkap pertandingan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="{{ route('matches.store') }}"
                            method="POST"
                            id="matchForm"
                            autocomplete="off"
                        >
                            @csrf
                            <div class="row g-4">
                                <!-- Kompetisi -->
                                <div class="col-md-6">
                                    <label
                                        for="competition_id"
                                        class="form-label text-white"
                                        style="font-weight: 500;"
                                    >
                                        <i
                                            class="fas fa-trophy me-2"
                                            style="color: var(--primary-light);"
                                        ></i>Kompetisi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="competition_id"
                                        id="competition_id"
                                        class="form-select @error('competition_id') is-invalid @enderror"
                                        required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: #fff;"
                                    >
                                        <option value="">Pilih Kompetisi...</option>
                                        @foreach ($competitions as $competition)
                                            <option
                                                value="{{ $competition->id }}"
                                                {{ old('competition_id') == $competition->id ? 'selected' : '' }}
                                            >
                                                {{ $competition->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('competition_id')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Venue -->
                                <div class="col-md-6">
                                    <label
                                        for="venue_id"
                                        class="form-label text-white"
                                        style="font-weight: 500;"
                                    >
                                        <i
                                            class="fas fa-map-marker-alt me-2"
                                            style="color: var(--primary-light);"
                                        ></i>Tempat (Venue)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="venue_id"
                                        id="venue_id"
                                        class="form-select @error('venue_id') is-invalid @enderror"
                                        required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: #fff;"
                                    >
                                        <option value="">Pilih Venue...</option>
                                        @foreach ($venues as $venue)
                                            <option
                                                value="{{ $venue->id }}"
                                                {{ old('venue_id') == $venue->id ? 'selected' : '' }}
                                            >
                                                {{ $venue->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('venue_id')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Tanggal & Waktu -->
                                <div class="col-12">
                                    <label
                                        for="date"
                                        class="form-label text-white"
                                        style="font-weight: 500;"
                                    >
                                        <i
                                            class="fas fa-calendar me-2"
                                            style="color: var(--primary-light);"
                                        ></i>Tanggal & Waktu Pertandingan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="datetime-local"
                                        name="date"
                                        id="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        value="{{ old('date') }}"
                                        required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: #fff;"
                                    >
                                    @error('date')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i>{{ $message }}
                                        </div>
                                    @enderror

                                    <div class="auto-status-badge mt-2">
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="fas fa-robot text-primary mt-1"></i>
                                            <div class="flex-grow-1">
                                                <strong class="d-block mb-2 text-white">🤖 Sistem Auto-Update
                                                    Status</strong>
                                                <ul class="small mb-0 ps-3 text-white">
                                                    <li class="mb-1">📅 <strong>Dijadwalkan (0)</strong> - Sebelum waktu
                                                        pertandingan</li>
                                                    <li class="mb-1">🔴 <strong>Live (1)</strong> - Saat waktu kick-off
                                                        tiba</li>
                                                    <li>✅ <strong>Selesai (2)</strong> - Otomatis 105 menit setelah kick-off
                                                    </li>
                                                </ul>
                                                <small class="d-block mt-2 text-white">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Status akan auto-update berdasarkan waktu
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tim Home -->
                                <div class="col-md-6">
                                    <label
                                        for="team_id_1"
                                        class="form-label text-white"
                                        style="font-weight: 500;"
                                    >
                                        <i
                                            class="fas fa-home me-2"
                                            style="color: var(--primary-light);"
                                        ></i>Tim Home
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="team_id_1"
                                        id="team_id_1"
                                        class="form-select @error('team_id_1') is-invalid @enderror"
                                        required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: #fff;"
                                    >
                                        <option value="">Pilih Tim Home...</option>
                                        @foreach ($teams as $team)
                                            <option
                                                value="{{ $team->id }}"
                                                {{ old('team_id_1') == $team->id ? 'selected' : '' }}
                                            >
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_id_1')
                                        <div class="error-message"><i
                                                class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tim Away -->
                                <div class="col-md-6">
                                    <label
                                        for="team_id_2"
                                        class="form-label text-white"
                                        style="font-weight: 500;"
                                    >
                                        <i
                                            class="fas fa-plane-departure me-2"
                                            style="color: var(--primary-light);"
                                        ></i>Tim Away
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="team_id_2"
                                        id="team_id_2"
                                        class="form-select @error('team_id_2') is-invalid @enderror"
                                        required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: #fff;"
                                    >
                                        <option value="">Pilih Tim Away...</option>
                                        @foreach ($teams as $team)
                                            <option
                                                value="{{ $team->id }}"
                                                {{ old('team_id_2') == $team->id ? 'selected' : '' }}
                                            >
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_id_2')
                                        <div class="error-message"><i
                                                class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                                    @enderror
                                    <div
                                        id="sameTeamError"
                                        class="error-message"
                                        style="display: none;"
                                    >
                                        <i class="fas fa-exclamation-circle"></i>Tim Home dan Away tidak boleh sama!
                                    </div>
                                </div>

                                <!-- Link Match / Ticket -->
                                <div class="col-12">
                                    <label
                                        for="link_ticket"
                                        class="form-label text-white"
                                        style="font-weight: 500;"
                                    >
                                        <i
                                            class="fas fa-link me-2"
                                            style="color: var(--primary-light);"
                                        ></i>Link Match / Ticket
                                        <small class="text-muted">(Opsional)</small>
                                    </label>
                                    <input
                                        type="url"
                                        name="link_ticket"
                                        id="link_ticket"
                                        class="form-control @error('link_ticket') is-invalid @enderror"
                                        value="{{ old('link_ticket') }}"
                                        placeholder="https://..."
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: #fff;"
                                    >
                                    @error('link_ticket')
                                        <div class="error-message"><i
                                                class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Winner -->
                                <div class="col-md-6">
                                    <label
                                        for="winner_team_id"
                                        class="form-label text-white"
                                        style="font-weight: 500;"
                                    >
                                        <i
                                            class="fas fa-trophy me-2"
                                            style="color: var(--primary-light);"
                                        ></i>Pemenang
                                        <small class="text-muted">(Opsional)</small>
                                    </label>
                                    <select
                                        name="winner_team_id"
                                        id="winner_team_id"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: #fff;"
                                    >
                                        <option
                                            value=""
                                            selected
                                        >Pilih Pemenang...</option>
                                        <option
                                            value="0"
                                            {{ old('winner_team_id') == '0' ? 'selected' : '' }}
                                        >Draw</option>
                                        @foreach ($teams as $team)
                                            <option
                                                value="{{ $team->id }}"
                                                {{ old('winner_team_id') == $team->id ? 'selected' : '' }}
                                            >
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status Manual (Optional) -->
                                <div class="col-md-6">
                                    <label
                                        for="status"
                                        class="form-label text-white"
                                        style="font-weight: 500;"
                                    >
                                        <i
                                            class="fas fa-flag-checkered me-2"
                                            style="color: var(--primary-light);"
                                        ></i>Status Manual
                                        <small class="text-muted">(Opsional)</small>
                                    </label>
                                    <select
                                        name="status"
                                        id="status"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: #fff;"
                                    >
                                        <option
                                            value=""
                                            {{ old('status') === '' ? 'selected' : '' }}
                                        >🤖 Auto (Berdasarkan Waktu)</option>
                                        <option
                                            value="0"
                                            {{ old('status') == '0' ? 'selected' : '' }}
                                        >📅 Dijadwalkan</option>
                                        <option
                                            value="1"
                                            {{ old('status') == '1' ? 'selected' : '' }}
                                        >🔴 Sedang Berlangsung</option>
                                        <option
                                            value="2"
                                            {{ old('status') == '2' ? 'selected' : '' }}
                                        >✅ Selesai</option>
                                    </select>
                                    <small class="d-block mt-1 text-white">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Kosongkan untuk auto-update berdasarkan waktu
                                    </small>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="/admin/matches"
                                    class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                >
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button
                                    type="submit"
                                    id="submitBtn"
                                    class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                >
                                    <i class="fas fa-save me-2"></i>Simpan Pertandingan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Column -->
            <div class="col-lg-4">
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border);"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle p-2"
                                style="background: rgba(59,130,246,0.1);"
                            >
                                <i
                                    class="fas fa-eye"
                                    style="color: var(--info); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0 text-white"
                                    style="font-weight: 600;"
                                >Preview</h5>
                                <small class="text-white">Pratinjau hasil input</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <h5
                            id="preview-competition"
                            class="text-white"
                        >Nama Kompetisi</h5>
                        <p
                            id="preview-date"
                            class="small text-white"
                        >Tanggal Pertandingan</p>
                        <div
                            id="preview-match"
                            class="my-3"
                        >
                            <h6
                                id="preview-home"
                                class="text-white"
                            >Home</h6>
                            <p class="text-white">vs</p>
                            <h6
                                id="preview-away"
                                class="text-white"
                            >Away</h6>
                            <p
                                id="preview-score"
                                class="small mt-2 text-white"
                            >0 - 0</p>
                        </div>
                        <div class="mb-2">
                            <span
                                id="preview-winner"
                                class="badge bg-secondary"
                            >Pemenang</span>
                        </div>
                        <div>
                            <span
                                id="preview-status"
                                class="badge bg-info"
                            >🤖 Auto</span>
                            <p
                                id="preview-venue"
                                class="small mt-2 text-white"
                            >Venue belum dipilih</p>
                            <p
                                id="preview-link"
                                class="small text-white-50"
                            >Link: -</p>
                        </div>
                    </div>
                </div>

                <!-- Helper Tips -->
                <div
                    class="card mt-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
                >
                    <div class="card-body p-3">
                        <h6 class="mb-3 text-white"><i
                                class="fas fa-lightbulb me-2"
                                style="color: var(--primary-light);"
                            ></i>Tips Pengisian</h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-2">✅ Pastikan Tim Home dan Away berbeda</li>
                            <li class="mb-2">📅 Tanggal akan menentukan status otomatis</li>
                            <li>🤖 Status auto-update setiap page refresh</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('matchForm');
            const submitBtn = document.getElementById('submitBtn');
            const teamHomeSelect = document.getElementById('team_id_1');
            const teamAwaySelect = document.getElementById('team_id_2');
            const sameTeamError = document.getElementById('sameTeamError');

            // Validation: Same team check
            function validateTeams() {
                if (teamHomeSelect.value && teamAwaySelect.value && teamHomeSelect.value === teamAwaySelect.value) {
                    teamHomeSelect.classList.add('is-invalid');
                    teamAwaySelect.classList.add('is-invalid');
                    sameTeamError.style.display = 'flex';
                    return false;
                } else {
                    teamHomeSelect.classList.remove('is-invalid');
                    teamAwaySelect.classList.remove('is-invalid');
                    sameTeamError.style.display = 'none';
                    return true;
                }
            }

            teamHomeSelect.addEventListener('change', validateTeams);
            teamAwaySelect.addEventListener('change', validateTeams);

            // AJAX: Load teams when competition changes
            document.getElementById('competition_id').addEventListener('change', function() {
                const competitionId = this.value;

                // Reset dropdowns
                teamHomeSelect.innerHTML = '<option value="">Pilih Tim Home...</option>';
                teamAwaySelect.innerHTML = '<option value="">Pilih Tim Away...</option>';

                if (!competitionId) {
                    updatePreview();
                    return;
                }

                // Show loading
                teamHomeSelect.innerHTML = '<option value="">Memuat tim...</option>';
                teamAwaySelect.innerHTML = '<option value="">Memuat tim...</option>';

                fetch(`/admin/matches/get-teams/${competitionId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal mengambil data');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && Array.isArray(data.teams)) {
                            teamHomeSelect.innerHTML = '<option value="">Pilih Tim Home...</option>';
                            teamAwaySelect.innerHTML = '<option value="">Pilih Tim Away...</option>';

                            data.teams.forEach(team => {
                                const opt1 = document.createElement('option');
                                opt1.value = team.id;
                                opt1.textContent = team.name;
                                teamHomeSelect.appendChild(opt1);

                                const opt2 = document.createElement('option');
                                opt2.value = team.id;
                                opt2.textContent = team.name;
                                teamAwaySelect.appendChild(opt2);
                            });
                        } else {
                            throw new Error('Format data tidak valid');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        teamHomeSelect.innerHTML = '<option value="">Gagal memuat tim</option>';
                        teamAwaySelect.innerHTML = '<option value="">Gagal memuat tim</option>';
                        showNotification('Gagal memuat daftar tim: ' + error.message, 'error');
                    })
                    .finally(() => {
                        updatePreview();
                    });
            });

            // Live Preview
            function updatePreview() {
                const competitionEl = document.getElementById('competition_id');
                const venueEl = document.getElementById('venue_id');
                const dateInput = document.getElementById('date');
                const scoreHomeEl = document.getElementById('score_team1');
                const scoreAwayEl = document.getElementById('score_team2');
                const winnerEl = document.getElementById('winner_team_id');
                const statusEl = document.getElementById('status');
                const linkInput = document.getElementById('link_ticket');

                document.getElementById('preview-competition').textContent =
                    competitionEl.options[competitionEl.selectedIndex]?.text || 'Nama Kompetisi';
                document.getElementById('preview-home').textContent =
                    teamHomeSelect.options[teamHomeSelect.selectedIndex]?.text || 'Home';
                document.getElementById('preview-away').textContent =
                    teamAwaySelect.options[teamAwaySelect.selectedIndex]?.text || 'Away';
                document.getElementById('preview-score').textContent =
                    `${scoreHomeEl.value || 0} - ${scoreAwayEl.value || 0}`;
                document.getElementById('preview-venue').textContent =
                    venueEl.options[venueEl.selectedIndex]?.text || 'Venue belum dipilih';

                // Date formatting
                if (dateInput.value) {
                    const d = new Date(dateInput.value);
                    document.getElementById('preview-date').textContent =
                        d.toLocaleString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) + ' WIB';
                } else {
                    document.getElementById('preview-date').textContent = 'Tanggal Pertandingan';
                }

                // Winner
                const winnerText = winnerEl.options[winnerEl.selectedIndex]?.text || 'Pemenang';
                const winnerBadge = document.getElementById('preview-winner');
                winnerBadge.textContent = winnerText;
                winnerBadge.className = winnerEl.value === '0' ? 'badge bg-warning text-dark' :
                    winnerEl.value ? 'badge bg-primary' : 'badge bg-secondary';

                // Status
                const statusLabels = {
                    '': '🤖 Auto',
                    '0': '📅 Dijadwalkan',
                    '1': '🔴 Live',
                    '2': '✅ Selesai'
                };
                const statusColors = {
                    '': 'bg-info',
                    '0': 'bg-primary',
                    '1': 'bg-danger',
                    '2': 'bg-success'
                };
                const statusBadge = document.getElementById('preview-status');
                statusBadge.textContent = statusLabels[statusEl.value] || 'Status';
                statusBadge.className = 'badge ' + (statusColors[statusEl.value] || 'bg-secondary');

                // Link
                document.getElementById('preview-link').textContent =
                    linkInput.value ? `Link: ${linkInput.value}` : 'Link: -';
            }

            // Event listeners for preview
            ['competition_id', 'team_id_1', 'team_id_2', 'venue_id', 'date', 'score_team1',
                'score_team2', 'winner_team_id', 'status', 'link_ticket'
            ].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('change', updatePreview);
                    el.addEventListener('input', updatePreview);
                }
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                if (!validateTeams()) {
                    e.preventDefault();
                    showNotification('Tim Home dan Away tidak boleh sama!', 'error');
                    return;
                }

                const required = form.querySelectorAll('[required]');
                let valid = true;
                required.forEach(field => {
                    if (!field.value || (typeof field.value === 'string' && !field.value.trim())) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    showNotification('Harap lengkapi semua field yang wajib diisi!', 'error');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            });

            // Initialize preview
            updatePreview();
        });

        function showNotification(message, type = 'success') {
            const notif = document.createElement('div');
            notif.innerHTML = `
        <div style="display:flex;align-items:center;gap:10px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <div>${message}</div>
        </div>
    `;
            notif.style.cssText = `
        position: fixed; top: 20px; right: 20px; z-index: 11000;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white; padding: 12px 16px; border-radius: 10px; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        animation: slideInRight .25s ease;
    `;
            document.body.appendChild(notif);
            setTimeout(() => {
                notif.style.animation = 'slideOutRight .25s ease forwards';
                setTimeout(() => notif.remove(), 300);
            }, 3500);
        }
    </script>
@endsection
