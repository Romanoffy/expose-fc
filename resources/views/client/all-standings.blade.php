@extends('layouts.main')

@section('content')
    <!-- Hero Section -->
    <div
        class="hero overlay"
        style="background-image: url('{{ asset('assets/client/images/bg_5.jpg') }}'); min-height: 220px; display: flex; align-items: center; background-size: cover; background-position: center;"
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <h1
                        class="mb-2 text-white"
                        style="font-size: clamp(1.8rem, 5vw, 3.5rem); font-weight: 800; letter-spacing: 0.5px; line-height: 1.2; text-shadow: 0 2px 6px rgba(0,0,0,0.4);"
                    >
                        All Competition Standings
                    </h1>
                    <p
                        class="mt-2 text-white"
                        style="font-size: clamp(0.9rem, 3.5vw, 1.1rem); font-weight: 300; opacity: 0.9;"
                    >
                        Lihat klasemen semua kompetisi
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-3 mb-md-0 mb-3">
                    <h4
                        class="mb-0 text-white"
                        style="font-weight: 700; letter-spacing: 0.5px;"
                    >
                        All <span style="color: #007bff;">Standings</span>
                    </h4>
                </div>

                <div class="col-12 col-md-9">
                    <form
                        id="filterForm"
                        method="GET"
                        action="{{ route('standings.index') }}"
                    >
                        <div class="row g-2">
                            <div class="col-6 col-lg-3">
                                <select
                                    id="yearFilter"
                                    name="year"
                                    class="form-control filter-select"
                                >
                                    <option value="all">All Years</option>
                                    @foreach ($years as $year)
                                        <option
                                            value="{{ $year }}"
                                            {{ $selectedYear == $year ? 'selected' : '' }}
                                        >
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-lg-3">
                                <select
                                    id="categoryFilter"
                                    name="category"
                                    class="form-control filter-select"
                                >
                                    <option value="all">All Categories</option>
                                    <option
                                        value="internal"
                                        {{ $selectedCategory == 'internal' ? 'selected' : '' }}
                                    >Internal</option>
                                    <option
                                        value="external"
                                        {{ $selectedCategory == 'external' ? 'selected' : '' }}
                                    >External</option>
                                    <option
                                        value="friendly"
                                        {{ $selectedCategory == 'friendly' ? 'selected' : '' }}
                                    >Friendly</option>
                                </select>
                            </div>
                            <div class="col-6 col-lg-3">
                                <select
                                    id="eventFilter"
                                    name="event"
                                    class="form-control filter-select"
                                >
                                    <option value="all">All Events</option>
                                    @foreach ($events as $event)
                                        <option
                                            value="{{ $event }}"
                                            {{ $selectedEvent == $event ? 'selected' : '' }}
                                        >
                                            {{ $event }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- All Standings Section -->
    <div class="all-standings-page">
        <div
            class="container"
            id="standingsContent"
        >
            @if ($competitions->count() > 0)
                @foreach ($competitions as $competition)
                    @php
                        // PRIORITAS 1: Get teams from teams_competitions (registered teams)
                        $teamIds = \App\Models\TeamsCompetitions::where('competition_id', $competition->id)
                            ->pluck('team_id')
                            ->unique();

                        // FALLBACK: If no teams in teams_competitions, get from matches
                        if ($teamIds->isEmpty()) {
                            $teamIds = \App\Models\Matches::where('competition_id', $competition->id)
                                ->whereIn('status', [
                                    \App\Models\Matches::STATUS_SCHEDULED,
                                    \App\Models\Matches::STATUS_FINISHED,
                                ])
                                ->get()
                                ->flatMap(function ($match) {
                                    return [$match->team_id_1, $match->team_id_2];
                                })
                                ->unique()
                                ->values();
                        }

                        $standings = [];

                        foreach ($teamIds as $teamId) {
                            $team = \App\Models\Teams::find($teamId);
                            if (!$team) {
                                continue;
                            }

                            // Get only FINISHED matches
                            $matches = \App\Models\Matches::where('competition_id', $competition->id)
                                ->where('status', \App\Models\Matches::STATUS_FINISHED)
                                ->where(function ($query) use ($teamId) {
                                    $query->where('team_id_1', $teamId)->orWhere('team_id_2', $teamId);
                                })
                                ->get();

                            $stats = [
                                'team_id' => $teamId,
                                'team' => $team,
                                'matches_played' => $matches->count(),
                                'wins' => 0,
                                'draws' => 0,
                                'losses' => 0,
                                'goals_for' => 0,
                                'goals_against' => 0,
                                'goal_difference' => 0,
                                'points' => 0,
                            ];

                            foreach ($matches as $match) {
                                $isHome = $match->team_id_1 == $teamId;
                                $teamScore = $isHome ? $match->score_team1 : $match->score_team2;
                                $opponentScore = $isHome ? $match->score_team2 : $match->score_team1;

                                $stats['goals_for'] += $teamScore;
                                $stats['goals_against'] += $opponentScore;

                                if ($teamScore > $opponentScore) {
                                    $stats['wins']++;
                                    $stats['points'] += 3;
                                } elseif ($teamScore == $opponentScore) {
                                    $stats['draws']++;
                                    $stats['points'] += 1;
                                } else {
                                    $stats['losses']++;
                                }
                            }

                            $stats['goal_difference'] = $stats['goals_for'] - $stats['goals_against'];
                            $standings[] = (object) $stats;
                        }

                        // Sort by points, then goal difference, then goals for
                        usort($standings, function ($a, $b) {
                            if ($b->points != $a->points) {
                                return $b->points - $a->points;
                            }
                            if ($b->goal_difference != $a->goal_difference) {
                                return $b->goal_difference - $a->goal_difference;
                            }
                            return $b->goals_for - $a->goals_for;
                        });

                        $categoryColor = match ($competition->category ?? 'internal') {
                            'internal' => '#007bff',
                            'external' => '#f59e0b',
                            'friendly' => '#10b981',
                            default => '#6b7280',
                        };

                        // ✅ Check if competition is active/ongoing
                        $isActive = false;
                        $isUpcoming = false;
                        $statusBadge = '';

                        if ($competition->tanggal_mulai && $competition->tanggal_selesai) {
                            $now = now();
                            $startDate = \Carbon\Carbon::parse($competition->tanggal_mulai);
                            $endDate = \Carbon\Carbon::parse($competition->tanggal_selesai);

                            if ($now->between($startDate, $endDate)) {
                                $isActive = true;
                                $statusBadge = 'ONGOING';
                            } elseif ($now->lt($startDate)) {
                                $isUpcoming = true;
                                $statusBadge = 'UPCOMING';
                            }
                        }
                    @endphp

                    <div class="standings-card-wrapper">
                        <div
                            class="standings-card {{ $isActive ? 'card-active' : '' }} {{ $isUpcoming ? 'card-upcoming' : '' }}">
                            {{-- Competition Header --}}
                            <div
                                class="standings-card-header"
                                style="border-color: {{ $categoryColor }}"
                            >
                                <h3 class="standings-card-title">
                                    <i class="fas fa-trophy"></i>
                                    Klasemen {{ $competition->name }} - {{ $competition->year }}
                                </h3>
                                <div class="standings-card-badges">
                                    @if ($statusBadge)
                                        <span class="status-badge-{{ $isActive ? 'active' : 'upcoming' }}">
                                            <i class="fas {{ $isActive ? 'fa-circle' : 'fa-clock' }}"></i>
                                            {{ $statusBadge }}
                                        </span>
                                    @endif
                                    <span
                                        class="competition-badge-card"
                                        style="background: {{ $categoryColor }}"
                                    >
                                        {{ strtoupper($competition->category ?? 'INTERNAL') }}
                                    </span>
                                    <span class="event-badge-card">
                                        {{ $competition->event_type ?? 'Event' }}
                                    </span>
                                </div>
                            </div>

                            @if (count($standings) > 0)
                                {{-- Standings Table --}}
                                <div class="standings-card-table-wrapper">
                                    <table class="standings-card-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Team</th>
                                                <th>MP</th>
                                                <th>W</th>
                                                <th>D</th>
                                                <th>L</th>
                                                <th>GF</th>
                                                <th>GA</th>
                                                <th>GD</th>
                                                <th>PTS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($standings as $index => $standing)
                                                <tr>
                                                    <td class="position-cell-card">
                                                        @if ($index == 0)
                                                            <span
                                                                class="qualification-badge-card qual-champion-card"></span>
                                                        @elseif($index < 4)
                                                            <span class="qualification-badge-card qual-playoff-card"></span>
                                                        @endif
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td>
                                                        <div class="team-cell-card">
                                                            @if ($standing->team->logo)
                                                                <img
                                                                    src="{{ asset('storage/' . $standing->team->logo) }}"
                                                                    alt="{{ $standing->team->name }}"
                                                                    class="team-logo-small-card"
                                                                >
                                                            @else
                                                                <div class="team-logo-placeholder-card">
                                                                    {{ substr($standing->team->name, 0, 1) }}
                                                                </div>
                                                            @endif
                                                            <span class="team-name-card">
                                                                {{ $standing->team->name }}
                                                                @if ($index == 0 && $standing->points > 0)
                                                                    <span class="champion-badge-card">TOP</span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $standing->matches_played }}</td>
                                                    <td>{{ $standing->wins }}</td>
                                                    <td>{{ $standing->draws }}</td>
                                                    <td>{{ $standing->losses }}</td>
                                                    <td>{{ $standing->goals_for }}</td>
                                                    <td>{{ $standing->goals_against }}</td>
                                                    <td
                                                        class="goal-diff-card"
                                                        style="color: {{ $standing->goal_difference >= 0 ? '#10b981' : '#ef4444' }}"
                                                    >
                                                        {{ $standing->goal_difference > 0 ? '+' : '' }}{{ $standing->goal_difference }}
                                                    </td>
                                                    <td class="points-cell-card">{{ $standing->points }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Legend --}}
                                <div class="standings-card-legend">
                                    <div class="legend-items">
                                        <div class="legend-item">
                                            <span class="qualification-badge-card qual-champion-card"></span>
                                            <span>Champion Position</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="qualification-badge-card qual-playoff-card"></span>
                                            <span>Playoff Position</span>
                                        </div>
                                    </div>
                                    <div class="legend-abbr">
                                        MP: Matches Played | W: Wins | D: Draws | L: Losses |
                                        GF: Goals For | GA: Goals Against | GD: Goal Difference | PTS: Points
                                    </div>
                                </div>
                            @else
                                {{-- Empty State: Kompetisi baru tanpa tim --}}
                                <div class="empty-state-card">
                                    <i class="fas fa-info-circle"></i>
                                    <h4>Klasemen Masih Kosong</h4>
                                    <p>Belum ada tim yang terdaftar untuk kompetisi ini. Silakan tambahkan tim terlebih
                                        dahulu.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                {{-- No Competitions --}}
                <div class="no-competitions-state">
                    <i class="fas fa-trophy"></i>
                    <h3>Tidak Ada Kompetisi Ditemukan</h3>
                    <p>Coba sesuaikan filter Anda atau tidak ada kompetisi yang cocok dengan kriteria.</p>
                    <a
                        href="{{ route('standings.index') }}"
                        class="btn-back-home"
                    >
                        <i class="fas fa-redo"></i> Reset Filter
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Filter Section - Same as tournament */
        .filter-section {
            padding: 20px 0;
            position: sticky;
            top: 0;
            color: black;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            background: linear-gradient(115deg, rgb(10, 14, 24));
            transition: background 0.3s ease;
        }

        .filter-select {
            border-radius: 12px;
            border: 2px solid #2d3748;
            font-weight: 500;
            color: #1a202c;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-select option {
            color: #1a202c;
        }

        .filter-select:hover {
            border-color: #007bff;
            transform: translateY(-2px);
            color: black;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }

        .filter-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.15);
            outline: none;
            color: black;
        }

        .all-standings-page {
            background: rgb(10, 14, 24);
            min-height: 100vh;
            padding: 60px 0;
        }

        .standings-card-wrapper {
            margin-bottom: 40px;
        }

        .standings-card {
            background: rgba(35, 41, 49, 0.95);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .standings-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 123, 255, 0.2);
        }

        /* ✅ Active Competition Highlight */
        /* .standings-card.card-active {
                border: 2px solid #10b981;
                box-shadow: 0 4px 25px rgba(16, 185, 129, 0.3);
                position: relative;
            } */

        .standings-card.card-active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            /* background: linear-gradient(90deg, #10b981, #34d399); */
            animation: pulse-border 2s ease-in-out infinite;
        }

        @keyframes pulse-border {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        /* ✅ Upcoming Competition Highlight */
        /* .standings-card.card-upcoming {
                border: 2px solid #fbbf24;
                box-shadow: 0 4px 25px rgba(251, 191, 36, 0.2);
            } */

        /* ✅ Status Badges */
        .status-badge-active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 8px 16px;
            border-radius: 16px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .status-badge-active i {
            animation: blink 1.5s ease-in-out infinite;
            font-size: 0.6rem;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
            }

            50% {
                box-shadow: 0 4px 20px rgba(16, 185, 129, 0.6);
            }
        }

        .status-badge-upcoming {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #1a202c;
            padding: 8px 16px;
            border-radius: 16px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .standings-card-header {
            padding: 25px;
            border-bottom: 3px solid #007bff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .standings-card-title {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .standings-card-title i {
            color: #007bff;
            margin-right: 10px;
        }

        .standings-card-badges {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .competition-badge-card {
            color: white;
            padding: 8px 16px;
            border-radius: 16px;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .event-badge-card {
            background: rgba(100, 116, 139, 0.3);
            color: #94a3b8;
            padding: 8px 16px;
            border-radius: 16px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .standings-card-table-wrapper {
            overflow-x: auto;
        }

        .standings-card-table {
            width: 100%;
            border-collapse: collapse;
            font-size: clamp(0.75rem, 1.8vw, 0.9rem);
        }

        .standings-card-table thead {
            background: rgba(0, 123, 255, 0.1);
            border-bottom: 2px solid rgba(0, 123, 255, 0.5);
        }

        .standings-card-table th {
            color: #94a3b8;
            font-size: clamp(0.65rem, 1.5vw, 0.75rem);
            text-transform: uppercase;
            font-weight: 700;
            padding: clamp(12px, 2vw, 15px) clamp(8px, 1.5vw, 12px);
            text-align: center;
        }

        .standings-card-table th:first-child {
            text-align: left;
            padding-left: clamp(15px, 2vw, 25px);
        }

        .standings-card-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .standings-card-table tbody tr:hover {
            background: rgba(0, 123, 255, 0.05);
        }

        .standings-card-table td {
            padding: clamp(12px, 2vw, 15px) clamp(8px, 1.5vw, 12px);
            text-align: center;
            color: #94a3b8;
        }

        .standings-card-table td:first-child {
            text-align: left;
        }

        .position-cell-card {
            font-weight: 700;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            color: #ffffff;
            padding-left: clamp(15px, 2vw, 25px) !important;
        }

        .team-cell-card {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .team-logo-small-card {
            width: clamp(28px, 5vw, 35px);
            height: clamp(28px, 5vw, 35px);
            object-fit: contain;
            flex-shrink: 0;
        }

        .team-logo-placeholder-card {
            width: clamp(28px, 5vw, 35px);
            height: clamp(28px, 5vw, 35px);
            background: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: clamp(0.7rem, 2vw, 0.85rem);
            flex-shrink: 0;
        }

        .team-name-card {
            color: #ffffff;
            font-weight: 600;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
        }

        .champion-badge-card {
            background: rgb(13, 18, 107);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: clamp(0.6rem, 1.5vw, 0.7rem);
            font-weight: 700;
            margin-left: 8px;
        }

        .qualification-badge-card {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .qual-champion-card {
            background: #fbbf24;
            box-shadow: 0 0 6px #fbbf24;
        }

        .qual-playoff-card {
            background: #10b981;
            box-shadow: 0 0 6px #10b981;
        }

        .goal-diff-card {
            font-weight: 600;
        }

        .points-cell-card {
            color: white !important;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
        }

        .standings-card-legend {
            padding: 20px 25px;
            background: rgba(45, 52, 64, 0.4);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .legend-items {
            display: flex;
            gap: 20px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .legend-abbr {
            color: #64748b;
            font-size: 0.75rem;
            line-height: 1.6;
        }

        .empty-state-card {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }

        .empty-state-card i {
            font-size: 3rem;
            opacity: 0.5;
            margin-bottom: 15px;
            color: #007bff;
        }

        .empty-state-card h4 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .empty-state-card p {
            font-size: 1rem;
            margin: 0;
        }

        .no-competitions-state {
            text-align: center;
            padding: 100px 20px;
            background: rgba(35, 41, 49, 0.95);
            border-radius: 16px;
            color: #94a3b8;
        }

        .no-competitions-state i {
            font-size: 5rem;
            opacity: 0.5;
            margin-bottom: 25px;
            color: #007bff;
        }

        .no-competitions-state h3 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 2rem;
        }

        .no-competitions-state p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn-back-home {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .btn-back-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .all-standings-page {
                padding: 40px 0;
            }

            .filter-section {
                padding: 12px 0;
                background: linear-gradient(180deg, rgb(10, 14, 24) 60%, rgb(13, 18, 107) 100%);
            }

            .standings-card-header {
                padding: 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .standings-card-title {
                font-size: 1.2rem;
            }

            .competition-badge-card,
            .event-badge-card {
                font-size: 0.75rem;
                padding: 6px 12px;
            }

            /* ✅ Status badge responsive */
            .status-badge-active,
            .status-badge-upcoming {
                font-size: 0.65rem;
                padding: 6px 12px;
            }

            .standings-card-table {
                font-size: 0.7rem;
            }

            .standings-card-table th,
            .standings-card-table td {
                padding: 10px 6px;
            }

            .standings-card-legend {
                padding: 15px;
            }

            .legend-items {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {

            .standings-card-table th,
            .standings-card-table td {
                padding: 8px 4px;
                font-size: 0.65rem;
            }

            .standings-card-table th {
                font-size: 0.6rem;
            }

            .position-cell-card {
                font-size: 0.75rem;
                padding-left: 10px !important;
            }

            .team-logo-small-card,
            .team-logo-placeholder-card {
                width: 22px;
                height: 22px;
            }

            .team-name-card {
                font-size: 0.7rem;
            }

            .champion-badge-card {
                font-size: 0.55rem;
                padding: 1px 4px;
            }

            .qualification-badge-card {
                width: 4px;
                height: 4px;
            }

            .points-cell-card {
                font-size: 0.85rem;
            }

            /* ✅ Status badge mobile */
            .status-badge-active,
            .status-badge-upcoming {
                font-size: 0.6rem;
                padding: 4px 8px;
            }

            .status-badge-active i,
            .status-badge-upcoming i {
                font-size: 0.5rem;
            }
        }
    </style>

    <script>
        // Filter form submission with AJAX
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            const yearFilter = document.getElementById('yearFilter');
            const categoryFilter = document.getElementById('categoryFilter');
            const eventFilter = document.getElementById('eventFilter');

            // Add change event listeners
            [yearFilter, categoryFilter, eventFilter].forEach(filter => {
                filter.addEventListener('change', function() {
                    submitFilter();
                });
            });

            function submitFilter() {
                const year = yearFilter.value;
                const category = categoryFilter.value;
                const event = eventFilter.value;
                const contentDiv = document.getElementById('standingsContent');

                // Show loading state
                contentDiv.innerHTML = `
                <div id="loadingState" class="py-5 text-center">
                    <style>
                        @keyframes pulse {
                            0%, 100% { opacity: 1; }
                            50% { opacity: 0.6; }
                        }
                        @keyframes bounce {
                            0%, 100% { transform: translateY(0); }
                            50% { transform: translateY(-10px); }
                        }
                        .loading-container {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            gap: 8px;
                            margin-bottom: 2rem;
                        }
                        .loading-ball {
                            width: 12px;
                            height: 12px;
                            border-radius: 50%;
                            background: linear-gradient(135deg, #007bff, #0056b3);
                            animation: bounce 1.4s infinite ease-in-out;
                        }
                        .loading-ball:nth-child(1) { animation-delay: -0.32s; }
                        .loading-ball:nth-child(2) { animation-delay: -0.16s; }
                        .loading-ball:nth-child(3) { animation-delay: 0s; }
                        .loading-text {
                            background: linear-gradient(135deg, #007bff, #0056b3, #007bff);
                            background-size: 200% auto;
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-clip: text;
                            animation: pulse 2s ease-in-out infinite;
                            font-size: 1.5rem;
                            font-weight: 700;
                            margin-bottom: 0.5rem;
                        }
                    </style>
                    <div class="loading-container">
                        <div class="loading-ball"></div>
                        <div class="loading-ball"></div>
                        <div class="loading-ball"></div>
                    </div>
                    <h4 class="loading-text">Memuat Klasemen...</h4>
                    <p class="text-muted" style="font-size: 1rem; margin: 0; margin-top: 0.5rem;">
                        Harap tunggu sebentar
                    </p>
                </div>
            `;

                // Build URL with query parameters
                const url = new URL('{{ route('standings.filter') }}', window.location.origin);
                url.searchParams.append('year', year);
                url.searchParams.append('category', category);
                url.searchParams.append('event', event);

                // Fetch filtered data
                fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);

                        if (!response.ok) {
                            // Try to get error message from response
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                            }).catch(() => {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);

                        if (data.success && data.html) {
                            contentDiv.innerHTML = data.html;
                        } else if (data.html) {
                            // Even if success is false, try to render the HTML
                            contentDiv.innerHTML = data.html;
                        } else {
                            showEmptyState(contentDiv);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        showErrorState(contentDiv, error.message);
                    });
            }
        }

        /**
         * Display empty state when no competitions found
         */
        function showEmptyState(contentDiv) {
            contentDiv.innerHTML = `
            <div class="no-competitions-state">
                <i class="fas fa-trophy"></i>
                <h3>Tidak Ada Kompetisi Ditemukan</h3>
                <p>Coba sesuaikan filter Anda atau tidak ada kompetisi yang cocok dengan kriteria.</p>
                <a href="{{ route('standings.index') }}" class="btn-back-home">
                    <i class="fas fa-redo"></i> Reset Filter
                </a>
            </div>
        `;
        }

        /**
         * Display error state when fetch fails
         */
        function showErrorState(contentDiv, errorMessage) {
            contentDiv.innerHTML = `
            <div class="no-competitions-state" style="background: rgba(239, 68, 68, 0.05); border: 2px solid rgba(239, 68, 68, 0.3);">
                <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i>
                <h3 style="color: #ef4444;">Error Loading Standings</h3>
                <p style="color: #cbd5e1; font-size: 1rem; margin-bottom: 1.5rem;">
                    ${errorMessage}
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <button onclick="location.reload()" class="btn-back-home">
                        <i class="fas fa-sync"></i> Refresh Page
                    </button>
                    <a href="{{ route('standings.index') }}" class="btn-back-home" style="background: linear-gradient(135deg, #6b7280, #4b5563);">
                        <i class="fas fa-redo"></i> Reset Filter
                    </a>
                </div>
            </div>
        `;
        }
    </script>
@endsection
