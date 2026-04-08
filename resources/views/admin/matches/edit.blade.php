@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder,
        .form-select::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        .form-select option {
            background: #1a1d29;
            color: #fff;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Edit Match</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Perbarui informasi pertandingan
                    #{{ $matches_array->id }}</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/matches"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-futbol me-1"></i>Matches
                        </a>
                    </li>
                    <li
                        class="breadcrumb-item active"
                        style="color: var(--text-primary);"
                    >Edit #{{ $matches_array->id }}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle p-2"
                                style="background: rgba(245, 158, 11, 0.1);"
                            >
                                <i
                                    class="fas fa-edit"
                                    style="color: var(--warning); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Edit Informasi
                                    Match</h5>
                                <small class="text-white">Perbarui data pertandingan sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/matches/{{ $matches_array->id }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="matchEditForm"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Competition -->
                                <div class="col-12">
                                    <label
                                        for="competition_id"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-trophy me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Competition
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="competition_id"
                                        id="competition_id"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Select Competition...</option>
                                        @foreach ($competitions as $competition)
                                            <option
                                                value="{{ $competition->id }}"
                                                {{ $competition->id == $matches_array->competition_id ? 'selected' : '' }}
                                            >
                                                {{ $competition->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Team Home -->
                                <div class="col-md-6">
                                    <label
                                        for="team_id_1"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-home me-2"
                                            style="color: var(--success);"
                                        ></i>
                                        Team Home
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="team_id_1"
                                        id="team_id_1"
                                        onchange="updateTeamName(this, 'teamname_1_hidden')"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Select Home Team...</option>
                                        @foreach ($teams as $teamhome)
                                            <option
                                                value="{{ $teamhome->id }}"
                                                {{ $teamhome->id == $matches_array->team_id_1 ? 'selected' : '' }}
                                            >
                                                {{ $teamhome->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input
                                        type="hidden"
                                        value="{{ $matches_array->teamname_1 }}"
                                        id="teamname_1_hidden"
                                        name="teamname_1"
                                    >
                                </div>

                                <!-- Team Away -->
                                <div class="col-md-6">
                                    <label
                                        for="team_id_2"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-plane-departure me-2"
                                            style="color: var(--info);"
                                        ></i>
                                        Team Away
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="team_id_2"
                                        id="team_id_2"
                                        onchange="updateTeamName(this, 'teamname_2_hidden')"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Select Away Team...</option>
                                        @foreach ($teams as $teamaway)
                                            <option
                                                value="{{ $teamaway->id }}"
                                                {{ $teamaway->id == $matches_array->team_id_2 ? 'selected' : '' }}
                                            >
                                                {{ $teamaway->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input
                                        type="hidden"
                                        value="{{ $matches_array->teamname_2 }}"
                                        id="teamname_2_hidden"
                                        name="teamname_2"
                                    >
                                </div>
                                <!-- Winner -->
                                <div class="col-12">
                                    <label
                                        for="winner_team_id"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-medal me-2"
                                            style="color: var(--warning);"
                                        ></i>
                                        Winner
                                    </label>
                                    <select
                                        name="winner_team_id"
                                        id="winner_team_id"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                    >
                                        <option value="">Select Winner...</option>
                                        <option
                                            value="0"
                                            {{ $matches_array->winner_team_id == null ? 'selected' : '' }}
                                        >Draw</option>
                                        @foreach ($teams as $winnerteam)
                                            <option
                                                value="{{ $winnerteam->id }}"
                                                {{ $winnerteam->id == $matches_array->winner_team_id ? 'selected' : '' }}
                                            >
                                                {{ $winnerteam->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date Match -->
                                <div class="col-md-6">
                                    <label
                                        for="date"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-calendar-alt me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Date Match
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="datetime-local"
                                        name="date"
                                        id="date"
                                        value="{{ $matches_array->date }}"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                </div>

                                <!-- Venue -->
                                <div class="col-md-6">
                                    <label
                                        for="venue_id"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-map-marker-alt me-2"
                                            style="color: var(--error);"
                                        ></i>
                                        Venue
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="venue_id"
                                        id="venue_id"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Select Venue...</option>
                                        @foreach ($venues as $venue)
                                            <option
                                                value="{{ $venue->id }}"
                                                {{ $venue->id == $matches_array->venue_id ? 'selected' : '' }}
                                            >
                                                {{ $venue->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Link Ticket -->
                                <div class="col-md-6">
                                    <label
                                        for="link_ticket"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-ticket-alt me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Link Ticket Match
                                    </label>
                                    <input
                                        type="url"
                                        name="link_ticket"
                                        id="link_ticket"
                                        value="{{ $matches_array->link_ticket }}"
                                        class="form-control"
                                        placeholder="https://example.com/tickets"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                    >
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label
                                        for="status"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-flag-checkered me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Status
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="status"
                                        id="status"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Select Status...</option>
                                        <option
                                            value="0"
                                            {{ $matches_array->status == 0 ? 'selected' : '' }}
                                        >
                                            📅 Dijadwalkan
                                        </option>
                                        <option
                                            value="1"
                                            {{ $matches_array->status == 1 ? 'selected' : '' }}
                                        >
                                            🔴 Sedang Berlangsung
                                        </option>
                                        <option
                                            value="2"
                                            {{ $matches_array->status == 2 ? 'selected' : '' }}
                                        >
                                            ✅ Selesai
                                        </option>
                                    </select>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-robot me-1"></i>
                                        Status akan auto-update sesuai waktu pertandingan
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
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-warning"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                    id="updateBtn"
                                >
                                    <i class="fas fa-save me-2"></i>Update Match
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <!-- Current Match Card -->
                <div
                    class="card mb-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle p-2"
                                style="background: rgba(16, 185, 129, 0.1);"
                            >
                                <i
                                    class="fas fa-futbol"
                                    style="color: var(--success); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Match Preview
                                </h5>
                                <small class="text-white">Data pertandingan saat ini</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Match Status Badge -->
                        <div class="mb-3 text-center">
                            @php
                                $statusLabels = [0 => '📅 Dijadwalkan', 1 => '🔴 Live', 2 => '✅ Selesai'];
                                $statusColors = [0 => 'var(--primary)', 1 => 'var(--error)', 2 => 'var(--success)'];
                            @endphp
                            <span
                                id="preview_status"
                                class="badge"
                                style="background: {{ $statusColors[$matches_array->status] ?? 'var(--secondary)' }}; color: white; font-size: 11px; padding: 6px 12px; border-radius: 20px;"
                            >
                                {{ $statusLabels[$matches_array->status] ?? 'Unknown' }}
                            </span>
                        </div>

                        <!-- Match Score Display -->
                        <div
                            class="d-flex justify-content-between align-items-center mb-3 rounded p-3"
                            style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                        >
                            <div class="flex-fill text-center">
                                <div
                                    id="preview_team1"
                                    style="color: var(--text-primary); font-size: 14px; font-weight: 500; margin-bottom: 8px;"
                                >
                                    {{ $matches_array->teamname_1 }}
                                </div>
                                <div
                                    id="preview_score1"
                                    style="color: var(--success); font-size: 28px; font-weight: 700;"
                                >
                                    {{ $matches_array->score_team1 ?? '-' }}
                                </div>
                            </div>
                            <div class="px-3">
                                <span style="color: var(--text-light); font-size: 20px; font-weight: 300;">vs</span>
                            </div>
                            <div class="flex-fill text-center">
                                <div
                                    id="preview_team2"
                                    style="color: var(--text-primary); font-size: 14px; font-weight: 500; margin-bottom: 8px;"
                                >
                                    {{ $matches_array->teamname_2 }}
                                </div>
                                <div
                                    id="preview_score2"
                                    style="color: var(--info); font-size: 28px; font-weight: 700;"
                                >
                                    {{ $matches_array->score_team2 ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <!-- Match Details -->
                        <div class="small text-white">
                            <div
                                class="d-flex align-items-center mb-2 gap-2 rounded p-2"
                                style="background: var(--glass-bg);"
                            >
                                <i
                                    class="fas fa-trophy"
                                    style="color: var(--warning); width: 20px;"
                                ></i>
                                <span>Competition:</span>
                                <strong
                                    id="preview_competition"
                                    style="color: var(--text-primary);"
                                >
                                    @foreach ($competitions as $comp)
                                        @if ($comp->id == $matches_array->competition_id)
                                            {{ $comp->name }}
                                        @endif
                                    @endforeach
                                </strong>
                            </div>
                            <div
                                class="d-flex align-items-center mb-2 gap-2 rounded p-2"
                                style="background: var(--glass-bg);"
                            >
                                <i
                                    class="fas fa-map-marker-alt"
                                    style="color: var(--error); width: 20px;"
                                ></i>
                                <span>Venue:</span>
                                <strong
                                    id="preview_venue"
                                    style="color: var(--text-primary);"
                                >
                                    @foreach ($venues as $v)
                                        @if ($v->id == $matches_array->venue_id)
                                            {{ $v->name }}
                                        @endif
                                    @endforeach
                                </strong>
                            </div>
                            <div
                                class="d-flex align-items-center mb-2 gap-2 rounded p-2"
                                style="background: var(--glass-bg);"
                            >
                                <i
                                    class="fas fa-calendar"
                                    style="color: var(--info); width: 20px;"
                                ></i>
                                <span>Date:</span>
                                <strong
                                    id="preview_date"
                                    style="color: var(--text-primary);"
                                >{{ $matches_array->date }}</strong>
                            </div>
                            @if ($matches_array->link_ticket)
                                <div
                                    class="d-flex align-items-center gap-2 rounded p-2"
                                    style="background: var(--glass-bg);"
                                >
                                    <i
                                        class="fas fa-ticket-alt"
                                        style="color: var(--primary-light); width: 20px;"
                                    ></i>
                                    <a
                                        id="preview_ticket"
                                        href="{{ $matches_array->link_ticket }}"
                                        target="_blank"
                                        style="color: var(--primary-light); text-decoration: none;"
                                    >
                                        Buy Tickets
                                    </a>
                                </div>
                            @else
                                <div
                                    class="d-flex align-items-center gap-2 rounded p-2"
                                    style="background: var(--glass-bg);"
                                >
                                    <i
                                        class="fas fa-ticket-alt"
                                        style="color: var(--primary-light); width: 20px;"
                                    ></i>
                                    <a
                                        id="preview_ticket"
                                        href="#"
                                        style="display:none;"
                                    ></a>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Info Card -->
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-info-circle me-2"
                                style="color: var(--info);"
                            ></i>Info Update
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">Match ID: #{{ str_pad($matches_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Created:
                                {{ $matches_array->created_at ? $matches_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Last Update:
                                {{ $matches_array->updated_at ? $matches_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}
                            </li>
                            <li>Auto-calculate winner from scores</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('matchEditForm');
            const updateBtn = document.getElementById('updateBtn');
            const team1Select = document.getElementById('team_id_1');
            const team2Select = document.getElementById('team_id_2');
            const winnerSelect = document.getElementById('winner_team_id');
            const sameTeamError = document.getElementById('sameTeamError');

            // Validation: Same team check
            function validateTeams() {
                if (team1Select.value && team2Select.value && team1Select.value === team2Select.value) {
                    team1Select.classList.add('is-invalid');
                    team2Select.classList.add('is-invalid');
                    if (sameTeamError) sameTeamError.style.display = 'flex';
                    return false;
                } else {
                    team1Select.classList.remove('is-invalid');
                    team2Select.classList.remove('is-invalid');
                    if (sameTeamError) sameTeamError.style.display = 'none';
                    return true;
                }
            }

            team1Select.addEventListener('change', validateTeams);
            team2Select.addEventListener('change', validateTeams);

            // Live preview update
            function updatePreview() {
                const team1Name = team1Select.options[team1Select.selectedIndex]?.text || '-';
                const team2Name = team2Select.options[team2Select.selectedIndex]?.text || '-';
                const compSelect = document.getElementById('competition_id');
                const venueSelect = document.getElementById('venue_id');
                const dateInput = document.getElementById('date');
                const ticketInput = document.getElementById('link_ticket');
                const statusSelect = document.getElementById('status');
                const winnerText = winnerSelect.options[winnerSelect.selectedIndex]?.text || 'Pemenang';

                // Update names
                document.getElementById('preview_team1')?.textContent = team1Name;
                document.getElementById('preview_team2')?.textContent = team2Name;

                // Skor: TAMPILKAN "Auto dari goal" karena tidak diinput manual
                document.getElementById('preview_score1')?.textContent = '0';
                document.getElementById('preview_score2')?.textContent = '0';
                document.querySelector('#preview-score')?.textContent = '0 - 0 (auto dari goal)';

                // Competition & venue
                document.getElementById('preview_competition')?.textContent =
                    compSelect.options[compSelect.selectedIndex]?.text || '-';
                document.getElementById('preview_venue')?.textContent =
                    venueSelect.options[venueSelect.selectedIndex]?.text || '-';

                // Date
                if (dateInput.value) {
                    const d = new Date(dateInput.value);
                    document.getElementById('preview_date')?.textContent =
                        d.toLocaleString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) + ' WIB';
                } else {
                    document.getElementById('preview_date')?.textContent = '-';
                }

                // Ticket link
                const ticketEl = document.getElementById('preview_ticket');
                if (ticketEl) {
                    if (ticketInput.value) {
                        ticketEl.href = ticketInput.value;
                        ticketEl.textContent = 'Lihat Tiket';
                        ticketEl.style.display = 'inline';
                    } else {
                        ticketEl.style.display = 'none';
                    }
                }

                // Status badge
                const statusBadge = document.getElementById('preview_status');
                if (statusBadge) {
                    const statusLabels = {
                        '0': '📅 Dijadwalkan',
                        '1': '🔴 Live',
                        '2': '✅ Selesai',
                        '': '🤖 Auto'
                    };
                    const statusColors = {
                        '0': 'bg-primary',
                        '1': 'bg-danger',
                        '2': 'bg-success',
                        '': 'bg-info'
                    };
                    statusBadge.textContent = statusLabels[statusSelect.value] || 'Status';
                    statusBadge.className = 'badge ' + (statusColors[statusSelect.value] || 'bg-secondary');
                }

                // Winner badge
                const winnerBadge = document.getElementById('preview-winner');
                if (winnerBadge) {
                    winnerBadge.textContent = winnerText;
                    winnerBadge.className = winnerSelect.value === '0' ? 'badge bg-warning text-dark' :
                        winnerSelect.value ? 'badge bg-primary' : 'badge bg-secondary';
                }
            }

            // Event listeners for preview
            ['competition_id', 'team_id_1', 'team_id_2', 'venue_id', 'date', 'link_ticket', 'status',
                'winner_team_id'
            ]
            .forEach(id => {
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

                // Basic required field validation
                const required = form.querySelectorAll('[required]');
                let valid = true;
                required.forEach(field => {
                    if (!field.value.trim()) {
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

                // Loading state
                updateBtn.disabled = true;
                updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
            });

            // Initialize preview
            updatePreview();
        });

        // Notification function
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
