<div
                id="match-details"
                class="tab-content-section active"
            >
                <!-- Match Header Card -->
                <div class="match-card">
                    <div
                        class="match-card-header"
                        style="--category-color: {{ $categoryColor }}; border-top-color: {{ $categoryColor }};"
                    >
                        <div class="team-section">

                            <!-- Team 1 -->
                            <div class="team-column">
                                <div class="team-logo-section">
                                    <img
                                        src="{{ $match->team_logo_1 ? asset('storage/' . $match->team_logo_1) : asset('assets/client/images/EXPOSE FC.png') }}"
                                        alt="{{ $match->teamname_1 }}"
                                        class="team-logo rounded-circle"
                                    >
                                </div>
                                <h2 class="team-name-large">{{ $match->teamname_1 }}</h2>

                                @if ($goalsTeam1->count() > 0)
                                    @php
                                        // Group goals by player_id
                                        $groupedGoals = $goalsTeam1->groupBy('player_id');
                                    @endphp

                                    @foreach ($groupedGoals as $playerId => $playerGoals)
                                        <div
                                            class="goal-item"
                                            style="border-left-color: {{ $categoryColor }};"
                                        >
                                            @if ($playerGoals->first()->player && $playerGoals->first()->player->photo)
                                                <img
                                                    src="{{ asset('storage/' . $playerGoals->first()->player->photo) }}"
                                                    alt="{{ $playerGoals->first()->player->name }}"
                                                    class="player-avatar"
                                                    style="border-color: {{ $categoryColor }};"
                                                >
                                            @else
                                                <div
                                                    class="player-avatar"
                                                    style="background: {{ $categoryColor }}; display: flex; align-items: center; justify-content: center; border: 2px solid {{ $categoryColor }};"
                                                >
                                                    <i
                                                        class="fas fa-user"
                                                        style="color: white;"
                                                    ></i>
                                                </div>
                                            @endif

                                            <div class="goal-info">
                                                <p class="player-name">
                                                    {{ $playerGoals->first()->player->name ?? 'Unknown' }}</p>
                                                <p class="goal-time">
                                                    @foreach ($playerGoals as $goal)
                                                        ⚽ {{ $goal->minute }}'
                                                        @if ($goal->goal_type == 'penalty')
                                                            <span
                                                                style="background: #fbbf24; color: white; padding: 2px 6px; border-radius: 3px; font-size: 0.7rem; font-weight: 600;"
                                                            >(P)</span>
                                                        @elseif($goal->goal_type == 'own_goal')
                                                            <span
                                                                style="background: #ef4444; color: white; padding: 2px 6px; border-radius: 3px; font-size: 0.7rem; font-weight: 600;"
                                                            >(OG)</span>
                                                        @endif
                                                        @if (!$loop->last)
                                                            |
                                                        @endif
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="no-goals">
                                        <i class="fas fa-minus-circle"></i> No goals yet
                                    </div>
                                @endif
                            </div>

                            <!-- Match Center -->
                            <div class="match-center">
                                <span
                                    class="match-badge"
                                    style="color: {{ $categoryColor }}; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;"
                                >{{ strtoupper($categoryLabel) }}</span>
                                <p style="color: #94a3b8; font-size: 0.95rem; margin-bottom: 15px;">
                                    {{ $competition->event_type ?? 'Event' }}</p>

                                @if ($match->status)
                                    <div class="match-score">{{ $match->score_team1 ?? 0 }} -
                                        {{ $match->score_team2 ?? 0 }}
                                    </div>
                                    @php
                                        $totalGoals = $goalsTeam1->count() + $goalsTeam2->count();
                                    @endphp
                                    @if ($totalGoals > 0)
                                        <small style="color: #94a3b8; display: block; margin-bottom: 12px;">
                                            ⚽ {{ $totalGoals }} Goal{{ $totalGoals > 1 ? 's' : '' }} Recorded
                                        </small>
                                    @endif
                                    <span class="match-status">✓ Full Time</span>
                                @else
                                    <div
                                        class="match-score"
                                        style="background: linear-gradient(135deg, #007bff, #00d4ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"
                                    >VS</div>
                                    <span class="match-status upcoming">⏳ Upcoming</span>
                                @endif

                                <div class="match-info-grid">
                                    <div class="match-info-item">
                                        <i>📅 </i>
                                        {{ \Carbon\Carbon::parse($match->date)->format('d M Y') }}
                                    </div>
                                    <div class="match-info-item">
                                        <i class="far fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($match->date)->format('H:i') }} WIB
                                    </div>
                                    <div
                                        class="match-info-item"
                                        style="grid-column: 1 / -1;"
                                    >
                                        <i>📍 </i>
                                        {{ $match->venue_name ?? 'TBD' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Team 2 -->
                            <div class="team-column">
                                <div class="team-logo-section">
                                    <img
                                        src="{{ $match->team_logo_2 ? asset('storage/' . $match->team_logo_2) : asset('assets/client/images/EXPOSE FC.png') }}"
                                        alt="{{ $match->teamname_2 }}"
                                        class="team-logo rounded-circle"
                                    >
                                </div>
                                <h2 class="team-name-large">{{ $match->teamname_2 }}</h2>

                                @if ($goalsTeam2->count() > 0)
                                    @php
                                        // Group goals by player_id
                                        $groupedGoals = $goalsTeam2->groupBy('player_id');
                                    @endphp

                                    @foreach ($groupedGoals as $playerId => $playerGoals)
                                        <div
                                            class="goal-item"
                                            style="border-left-color: {{ $categoryColor }};"
                                        >
                                            @if ($playerGoals->first()->player && $playerGoals->first()->player->photo)
                                                <img
                                                    src="{{ asset('storage/' . $playerGoals->first()->player->photo) }}"
                                                    alt="{{ $playerGoals->first()->player->name }}"
                                                    class="player-avatar"
                                                    style="border-color: {{ $categoryColor }};"
                                                >
                                            @else
                                                <div
                                                    class="player-avatar"
                                                    style="background: {{ $categoryColor }}; display: flex; align-items: center; justify-content: center; border: 2px solid {{ $categoryColor }};"
                                                >
                                                    <i
                                                        class="fas fa-user"
                                                        style="color: white;"
                                                    ></i>
                                                </div>
                                            @endif

                                            <div class="goal-info">
                                                <p class="player-name">
                                                    {{ $playerGoals->first()->player->name ?? 'Unknown' }}</p>
                                                <p class="goal-time">
                                                    @foreach ($playerGoals as $goal)
                                                        ⚽ {{ $goal->minute }}'
                                                        @if ($goal->goal_type == 'penalty')
                                                            <span
                                                                style="background: #fbbf24; color: white; padding: 2px 6px; border-radius: 3px; font-size: 0.7rem; font-weight: 600;"
                                                            >(P)</span>
                                                        @elseif($goal->goal_type == 'own_goal')
                                                            <span
                                                                style="background: #ef4444; color: white; padding: 2px 6px; border-radius: 3px; font-size: 0.7rem; font-weight: 600;"
                                                            >(OG)</span>
                                                        @endif
                                                        @if (!$loop->last)
                                                            |
                                                        @endif
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="no-goals">
                                        <i class="fas fa-minus-circle"></i> No goals yet
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Head to Head Section -->
                <div
                    class="stats-section"
                    style="--category-color: {{ $categoryColor }}; border-color: {{ $categoryColor }}40;"
                >
                    <h3
                        class="section-title"
                        style="border-bottom-color: {{ $categoryColor }};"
                    >Head to Head Record</h3>

                    <div class="h2h-grid">
                        <div
                            class="h2h-stat"
                            style="background: rgba(16, 185, 129, 0.15); border-color: #10b981;"
                        >
                            <div
                                class="h2h-stat-number"
                                style="color: #10b981;"
                            >{{ $team1Stats['wins'] }}</div>
                            <div
                                class="h2h-stat-label"
                                style="color: #10b981;"
                            >Wins</div>
                            <div style="color: #94a3b8; font-size: 0.75rem; margin-top: 8px;">
                                {{ substr($team1->name ?? 'Team 1', 0, 12) }}</div>
                        </div>
                        <div
                            class="h2h-stat"
                            style="background: rgba(251, 191, 36, 0.15); border-color: #fbbf24;"
                        >
                            <div
                                class="h2h-stat-number"
                                style="color: #fbbf24;"
                            >{{ $team1Stats['draws'] }}</div>
                            <div
                                class="h2h-stat-label"
                                style="color: #fbbf24;"
                            >Draws</div>
                        </div>
                        <div
                            class="h2h-stat"
                            style="background: rgba(239, 68, 68, 0.15); border-color: #ef4444;"
                        >
                            <div
                                class="h2h-stat-number"
                                style="color: #ef4444;"
                            >{{ $team1Stats['losses'] }}</div>
                            <div
                                class="h2h-stat-label"
                                style="color: #ef4444;"
                            >Losses</div>
                            <div style="color: #94a3b8; font-size: 0.75rem; margin-top: 8px;">
                                {{ substr($team2->name ?? 'Team 2', 0, 12) }}</div>
                        </div>
                    </div>

                    @if ($headToHeadMatches && $headToHeadMatches->count() > 0)
                        @foreach ($headToHeadMatches as $h2h)
                            <div class="h2h-match">
                                <div
                                    class="h2h-team"
                                    style="grid-column: 1; grid-row: 1 / 3;"
                                >
                                    <img
                                        src="{{ $h2h->team1->logo ? asset('storage/' . $h2h->team1->logo) : asset('assets/client/images/EXPOSE FC.png') }}"
                                        alt="{{ $h2h->teamname_1 }}"
                                    >
                                    <div class="h2h-team-name">{{ substr($h2h->teamname_1, 0, 20) }}</div>
                                </div>
                                <div
                                    class="h2h-score"
                                    style="color: {{ $categoryColor }};"
                                >{{ $h2h->score_team1 }} - {{ $h2h->score_team2 }}</div>
                                <div class="h2h-date">{{ \Carbon\Carbon::parse($h2h->date)->format('d M Y') }}</div>
                                <div
                                    class="h2h-team"
                                    style="grid-column: 3; grid-row: 1 / 3;"
                                >
                                    <img
                                        src="{{ $h2h->team2->logo ? asset('storage/' . $h2h->team2->logo) : asset('assets/client/images/EXPOSE FC.png') }}"
                                        alt="{{ $h2h->teamname_2 }}"
                                    >
                                    <div class="h2h-team-name">{{ substr($h2h->teamname_2, 0, 20) }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-goals">
                            <i class="fas fa-chart-bar"></i> No previous meetings between these teams
                        </div>
                    @endif
                </div>

                <!-- Match Details Section -->
                <div
                    class="stats-section"
                    style="--category-color: {{ $categoryColor }};"
                >
                    <h3
                        class="section-title"
                        style="border-bottom-color: {{ $categoryColor }};"
                    >Match Details</h3>

                    <div class="details-grid">
                        <div class="detail-item">
                            <div class="detail-label">Competition</div>
                            <div class="detail-value">{{ $competition->name ?? 'N/A' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Year</div>
                            <div class="detail-value">{{ $competition->year ?? 'N/A' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Venue</div>
                            <div class="detail-value">🏟️ {{ $venue->name ?? 'TBD' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            @if ($match->status)
                                <span
                                    style="background: #10b981; color: white; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; display: inline-block;"
                                >✓ Completed</span>
                            @else
                                <span
                                    style="background: #fbbf24; color: white; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; display: inline-block;"
                                >⏳ Scheduled</span>
                            @endif
                        </div>
                    </div>

                    @if ($match->link_ticket && !$match->status)
                        <div style="text-align: center; margin-top: 20px;">
                            <a
                                href="{{ $match->link_ticket }}"
                                target="_blank"
                                style="background: linear-gradient(135deg, {{ $categoryColor }}, {{ $categoryColor }}dd); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;"
                            >
                                <i class="fas fa-ticket-alt"></i> Get Tickets
                            </a>
                        </div>
                    @endif
                </div>
            </div>