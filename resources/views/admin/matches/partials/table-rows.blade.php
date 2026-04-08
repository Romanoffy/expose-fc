@forelse(isset($matches) ? $matches : $matches_array as $match)
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
                #{{ str_pad($match->id, 3, '0', STR_PAD_LEFT) }}
            </span>
        </td>

        <!-- Kompetisi -->
        <td class="py-3">
            <div>
                <span class="fw-semibold d-block text-black">{{ $match->competition_name }}</span>
                @if ($match->event_type)
                    <small class="text-muted">
                        <i class="fas fa-tag me-1"></i>{{ $match->event_type }}
                    </small>
                @endif
            </div>
        </td>

        <!-- Tim Home -->
        <td class="py-3">
            <div class="d-flex align-items-center gap-2">
                <i
                    class="fas fa-home text-success"
                    style="font-size: 12px;"
                ></i>
                <span class="text-black">{{ $match->team_name_home }}</span>
            </div>
        </td>

        <!-- Tim Away -->
        <td class="py-3">
            <div class="d-flex align-items-center gap-2">
                <i
                    class="fas fa-plane text-info"
                    style="font-size: 12px;"
                ></i>
                <span class="text-black">{{ $match->team_name_away }}</span>
            </div>
        </td>

        <!-- Goals Count (dari relasi) -->
        <td class="py-3 text-center">
            @php
                $totalGoals = $match->goals->count();
                $team1Goals = $match->goals->where('team_id', $match->team_id_1)->count();
                $team2Goals = $match->goals->where('team_id', $match->team_id_2)->count();
            @endphp

            @if ($totalGoals > 0)
                <div class="text-center">
                    <div class="d-flex justify-content-center align-items-center mb-1 gap-2">
                        <span
                            class="badge bg-success"
                            style="font-size: 12px; padding: 4px 8px; min-width: 25px;"
                        >
                            {{ $team1Goals }}
                        </span>
                        <span
                            class="text-white"
                            style="font-size: 11px;"
                        >-</span>
                        <span
                            class="badge bg-danger"
                            style="font-size: 12px; padding: 4px 8px; min-width: 25px;"
                        >
                            {{ $team2Goals }}
                        </span>
                    </div>
                    <span
                        class="badge bg-primary"
                        style="font-size: 10px; padding: 3px 8px;"
                    >
                        <i class="fas fa-futbol me-1"></i>{{ $totalGoals }} goals
                    </span>
                </div>
            @else
                <span
                    class="badge bg-secondary"
                    style="font-size: 11px; padding: 4px 10px;"
                >
                    <i class="fas fa-minus-circle me-1"></i>No goals
                </span>
            @endif
        </td>

        <!-- Pemenang -->
        <td class="py-3">
            @if ($match->winner_team_name)
                <span
                    class="badge bg-warning text-dark"
                    style="font-size: 11px; padding: 4px 8px;"
                >
                    <i class="fas fa-trophy me-1"></i>{{ $match->winner_team_name }}
                </span>
            @else
                <span
                    class="badge bg-secondary"
                    style="font-size: 11px; padding: 4px 8px;"
                >
                    Draw
                </span>
            @endif
        </td>

        <!-- Venue -->
        <td class="py-3">
            <span
                class="text-black"
                style="font-size: 13px;"
            >
                <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $match->venue_name }}
            </span>
        </td>

        <!-- Status -->
        <td class="py-3 text-center">
            @php
                $statusLabels = [
                    0 => 'Dijadwalkan',
                    1 => 'Live',
                    2 => 'Selesai',
                ];
                $statusColors = [
                    0 => '#3b82f6',
                    1 => '#ef4444',
                    2 => '#10b981',
                ];
                $statusIcons = [
                    0 => 'calendar',
                    1 => 'circle',
                    2 => 'check-circle',
                ];
                $label = $statusLabels[$match->status] ?? 'Unknown';
                $color = $statusColors[$match->status] ?? '#6b7280';
                $icon = $statusIcons[$match->status] ?? 'question';
            @endphp

            <span
                class="badge {{ $match->status == 1 ? 'pulse-badge' : '' }}"
                style="background: {{ $color }}; color: white; font-size: 11px; padding: 5px 10px;"
            >
                <i class="fas fa-{{ $icon }} {{ $match->status == 1 ? 'blink-live' : '' }} me-1"></i>
                {{ $label }}
            </span>
            <br>
            <small
                class="text-muted"
                style="font-size: 10px;"
            >
                {{ \Carbon\Carbon::parse($match->date)->diffForHumans() }}
            </small>
        </td>

        <!-- Actions -->
        <td class="py-3 text-center">
            <div class="d-flex justify-content-center gap-1">
                <a
                    href="/admin/matches/{{ $match->id }}/edit"
                    class="btn btn-outline-primary btn-sm"
                    style="padding: 6px 10px; font-size: 12px;"
                    title="Edit Match"
                    data-bs-toggle="tooltip"
                >
                    <i class="fas fa-edit"></i>
                </a>

                <button
                    type="button"
                    class="btn btn-outline-danger btn-sm"
                    style="padding: 6px 10px; font-size: 12px;"
                    title="Hapus Match"
                    data-bs-toggle="tooltip"
                    onclick="confirmDelete({{ $match->id }}, '{{ $match->team_name_home }} vs {{ $match->team_name_away }}')"
                >
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td
            colspan="10"
            class="py-5 text-center"
        >
            <div style="color: var(--text-light);">
                <i class="fas fa-futbol fa-3x mb-3 opacity-50"></i>
                <h6 style="color: var(--text-secondary);">Tidak ada pertandingan yang sesuai dengan filter</h6>
                <p class="mb-3 text-white">Coba ubah filter atau reset semua filter</p>
            </div>
        </td>
    </tr>
@endforelse
