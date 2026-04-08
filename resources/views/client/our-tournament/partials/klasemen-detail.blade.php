<div
    id="standings"
    class="tab-content-section"
>
    <div
        class="stats-section"
        style="--category-color: {{ $categoryColor }};"
    >
        <h3
            class="section-title"
            style="border-bottom-color: {{ $categoryColor }};"
        >
            <i class="fas fa-trophy"></i> Klasemen {{ $competition->name ?? 'Competition' }}
        </h3>

        <!-- Standings Table -->
        <div style="overflow-x: auto;">
            <table class="standings-table">
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
                    @php
                        // Get standings dari controller
                        $standings = $standings ?? [];
                    @endphp

                    @forelse($standings as $index => $standing)
                        <tr>
                            <td class="position-cell">
                                @if ($index == 0)
                                    <span class="qualification-badge qual-champion"></span>
                                @elseif($index < 4)
                                    <span class="qualification-badge qual-playoff"></span>
                                @endif
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="team-cell">
                                    @if ($standing->team->logo)
                                        <img
                                            src="{{ asset('storage/' . $standing->team->logo) }}"
                                            alt="{{ $standing->team->name }}"
                                            class="team-logo-small rounded-circle"
                                        >
                                    @else
                                        <div class="team-logo-placeholder">
                                            {{ substr($standing->team->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="team-name-standings">
                                        {{ $standing->team->name }}
                                        @if ($index == 0)
                                            <span class="champion-badge">TOP</span>
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
                                style="color: {{ $standing->goal_difference >= 0 ? '#10b981' : '#ef4444' }}; font-weight: 600;">
                                {{ $standing->goal_difference > 0 ? '+' : '' }}{{ $standing->goal_difference }}
                            </td>
                            <td style="color: white; font-weight: 700; font-size: 1rem;">
                                {{ $standing->points }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="10"
                                class="no-goals"
                                style="text-align: center; padding: 40px;"
                            >
                                <i class="fas fa-table"></i>
                                <p style="margin-top: 10px;">Klasemen belum tersedia untuk kompetisi ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Legend -->
        @if (count($standings ?? []) > 0)
            <div style="margin-top: 25px; padding: 20px; background: rgba(45, 52, 64, 0.4); border-radius: 10px;">
                <div style="color: #64748b; font-size: 0.75rem;">
                    MP: Matches Played | W: Wins | D: Draws | L: Losses | GF: Goals For | GA: Goals Against |
                    GD: Goal Difference | PTS: Points
                </div>
            </div>
        @endif
    </div>
</div>
