{{-- resources/views/admin/match_goals/partials/table-rows.blade.php --}}
@forelse($matches as $match)
    <tr class="border-bottom" style="border-color: rgba(51, 65, 85, 0.3) !important; transition: var(--transition-fast);"
        onmouseover="this.style.background='rgba(99, 102, 241, 0.05)'"
        onmouseout="this.style.background='transparent'">

        <!-- ID -->
        <td class="px-4 py-3">
            <span class="badge" style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;">
                #{{ str_pad($match->id, 3, '0', STR_PAD_LEFT) }}
            </span>
        </td>

        <!-- Competition -->
        <td class="py-3">
            <span class="badge bg-info" style="font-size: 11px; padding: 4px 10px;">
                <i class="fas fa-trophy me-1"></i>{{ $match->competition->name ?? '-' }}
            </span>
        </td>

        <!-- Match Info -->
        <td class="py-3">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('storage/' . $match->team_logo_1) }}" alt="Team 1"
                        style="width: 28px; height: 28px; object-fit: cover; border-radius: 50%;">
                    <span class="fw-semibold text-black">{{ $match->teamname_1 }}</span>
                </div>
                <span class="text-muted fw-bold">vs</span>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('storage/' . $match->team_logo_2) }}" alt="Team 2"
                        style="width: 28px; height: 28px; object-fit: cover; border-radius: 50%;">
                    <span class="fw-semibold text-black">{{ $match->teamname_2 }}</span>
                </div>
            </div>
        </td>

        <!-- Date -->
        <td class="py-3">
            <div class="d-flex flex-column">
                <span class="text-black fw-semibold">{{ \Carbon\Carbon::parse($match->date)->format('d M Y') }}</span>
                <small class="text-muted">{{ \Carbon\Carbon::parse($match->date)->format('H:i') }} WIB</small>
            </div>
        </td>

        <!-- Score -->
        <td class="py-3 text-center">
            <div class="d-flex justify-content-center align-items-center gap-2">
                <span class="badge bg-success" style="font-size: 14px; padding: 6px 12px; min-width: 35px;">
                    {{ $match->score_team1 ?? 0 }}
                </span>
                <span class="fw-bold text-white">-</span>
                <span class="badge bg-danger" style="font-size: 14px; padding: 6px 12px; min-width: 35px;">
                    {{ $match->score_team2 ?? 0 }}
                </span>
            </div>
        </td>

        <!-- Goals Count -->
        <td class="py-3 text-center">
            @php
                $totalGoals = $match->goals->count();
            @endphp
            @if($totalGoals > 0)
                <span class="badge bg-primary" style="font-size: 12px; padding: 6px 12px;">
                    <i class="fas fa-futbol me-1"></i>{{ $totalGoals }} goals
                </span>
            @else
                <span class="badge bg-secondary" style="font-size: 11px; padding: 4px 10px;">
                    <i class="fas fa-minus-circle me-1"></i>No goals
                </span>
            @endif
        </td>

        <!-- Venue -->
        <td class="py-3">
            <span class="text-black" style="font-size: 13px;">
                <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $match->venue->name ?? '-' }}
            </span>
        </td>

        <!-- Status -->
        <td class="py-3 text-center">
            @php
                $statusLabels = [0 => 'Dijadwalkan', 1 => 'Live', 2 => 'Selesai'];
                $statusColors = [0 => '#3b82f6', 1 => '#ef4444', 2 => '#10b981'];
                $statusIcons = [0 => 'calendar', 1 => 'circle', 2 => 'check-circle'];
            @endphp
            <span class="badge {{ $match->status == 1 ? 'pulse-badge' : '' }}"
                style="background: {{ $statusColors[$match->status] ?? '#6b7280' }}; color: white; font-size: 11px; padding: 5px 10px;">
                <i class="fas fa-{{ $statusIcons[$match->status] ?? 'question' }} {{ $match->status == 1 ? 'blink-live' : '' }} me-1"></i>
                {{ $statusLabels[$match->status] ?? 'Unknown' }}
            </span>
        </td>

        <!-- Actions -->
        <td class="py-3 text-center">
            <a href="{{ route('match_goals.index', ['match_id' => $match->id]) }}"
                class="btn btn-outline-primary btn-sm" style="padding: 6px 12px; font-size: 12px;"
                title="Kelola Goal" data-bs-toggle="tooltip">
                <i class="fas fa-futbol me-1"></i>Kelola
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="py-5 text-center">
            <div style="color: var(--text-light);">
                <i class="fas fa-futbol fa-3x mb-3 opacity-50"></i>
                <h6 style="color: var(--text-secondary);">Tidak ada pertandingan yang sesuai dengan filter</h6>
                <p class="mb-3 text-white">Coba ubah filter atau reset semua filter</p>
                <a href="/admin/matches/create" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>Tambah Pertandingan
                </a>
            </div>
        </td>
    </tr>
@endforelse