@php
    // Calculate category color and label at the top level
    $categoryCode = $competition->category ?? 'internal';
    $categoryColor = match ($categoryCode) {
        'internal' => '#007bff',
        'external' => '#f59e0b',
        'friendly' => '#10b981',
        default => '#6b7280',
    };
    $categoryLabel = match ($categoryCode) {
        'internal' => 'Internal',
        'external' => 'External',
        'friendly' => 'Friendly',
        default => ucfirst($categoryCode),
    };
@endphp

<!-- Match Hero Section -->
<div
    style="margin: -20px -20px 20px -20px; background: rgb(10, 14, 24); padding: 16px; border-radius: 12px 12px 0 0; overflow-x: hidden;">
    <div
        style="background: rgba(35, 41, 49, 0.95) !important; border-radius: 12px; padding: 16px; border: 1px solid rgba(255, 255, 255, 0.08); border-top: 4px solid {{ $categoryColor }};">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; align-items: center;">

            <!-- Team 1 -->
            <div style="text-align: center; min-width: 0;">
                <div
                    style="width: 70px; height: 70px; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center;">
                    <img
                        src="{{ $match->team_logo_1 ? asset('storage/' . $match->team_logo_1) : asset('assets/client/images/EXPOSE FC.png') }}"
                        alt="{{ $match->teamname_1 }}"
                        style="max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 123, 255, 0.3));"
                    >
                </div>
                <h3
                    style="color: white; font-size: 0.85rem; font-weight: 700; margin-bottom: 10px; word-wrap: break-word;">
                    {{ $match->teamname_1 }}</h3>

                @if ($goalsTeam1->count() > 0)
                    @foreach ($goalsTeam1 as $goal)
                        <div
                            style="background: rgba(45, 52, 64, 0.6); border-radius: 8px; padding: 8px 12px; margin-bottom: 8px; border-left: 3px solid {{ $categoryColor }}; display: flex; align-items: center; gap: 10px;">
                            @if ($goal->player && $goal->player->photo)
                                <img
                                    src="{{ asset('storage/' . $goal->player->photo) }}"
                                    alt="{{ $goal->player->name }}"
                                    style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 2px solid {{ $categoryColor }}; flex-shrink: 0;"
                                >
                            @else
                                <div
                                    style="width: 30px; height: 30px; border-radius: 50%; background: {{ $categoryColor }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i
                                        class="fas fa-user"
                                        style="color: white; font-size: 0.8rem;"
                                    ></i>
                                </div>
                            @endif
                            <div style="flex: 1; text-align: left;">
                                <p style="color: white; font-weight: 600; font-size: 0.8rem; margin: 0;">
                                    {{ $goal->player->name ?? 'Unknown' }}</p>
                                <p style="color: #94a3b8; font-size: 0.7rem; margin: 0;">⚽ {{ $goal->minute }}'
                                    @if ($goal->goal_type == 'penalty')
                                        (P)
                                    @elseif($goal->goal_type == 'own_goal')
                                        (OG)
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            @php
                // Calculate goals count
                $team1GoalsCount =
                    $goalsTeam1->where('goal_type', '!=', 'own_goal')->count() +
                    $goalsTeam2->where('goal_type', 'own_goal')->count();
                $team2GoalsCount =
                    $goalsTeam2->where('goal_type', '!=', 'own_goal')->count() +
                    $goalsTeam1->where('goal_type', 'own_goal')->count();

                // Check if score matches goals
                $isScoreSynced = $match->score_team1 == $team1GoalsCount && $match->score_team2 == $team2GoalsCount;
            @endphp

            <!-- Match Center (UPDATE bagian score display) -->
            <div style="text-align: center; min-width: 0;">
                <span
                    style="background: linear-gradient(135deg, {{ $categoryColor }} 0%, {{ $categoryColor }}dd 100%); color: white; padding: 8px 14px; border-radius: 14px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; display: inline-block; margin-bottom: 12px; letter-spacing: 1px;"
                >
                    {{ $categoryLabel }}
                </span>
                <p style="color: #94a3b8; font-size: 0.8rem; margin-bottom: 8px;">
                    {{ $competition->event_type ?? 'Event' }}
                </p>

                @if ($match->status)
                    <div
                        style="font-size: 1.8rem; font-weight: 900; color: white; margin: 12px 0; letter-spacing: -1px;">
                        {{ $match->score_team1 ?? 0 }} - {{ $match->score_team2 ?? 0 }}
                    </div>

                    <!-- TAMBAHKAN: Sync Status & Goals Count -->
                    <div style="margin-bottom: 8px;">
                        @if ($goalsTeam1->count() + $goalsTeam2->count() > 0)
                            <small style="color: #94a3b8; font-size: 0.65rem; display: block;">
                                ⚽ {{ $goalsTeam1->count() + $goalsTeam2->count() }}
                                Goal{{ $goalsTeam1->count() + $goalsTeam2->count() > 1 ? 's' : '' }} Recorded
                            </small>
                            @if (!$isScoreSynced)
                                <small style="color: #fbbf24; font-size: 0.6rem; display: block; margin-top: 4px;">
                                    <i class="fas fa-exclamation-triangle"></i> Score may not reflect all goals
                                </small>
                            @else
                                <small style="color: #10b981; font-size: 0.6rem; display: block; margin-top: 4px;">
                                    <i class="fas fa-check-circle"></i> Score synced with goals
                                </small>
                            @endif
                        @else
                            <small style="color: #94a3b8; font-size: 0.65rem; display: block;">
                                <i class="fas fa-info-circle"></i> No goals recorded yet
                            </small>
                        @endif
                    </div>

                    <span
                        style="background: #10b981; color: white; padding: 5px 12px; border-radius: 12px; font-weight: 600; font-size: 0.7rem; display: inline-block;"
                    >
                        ✓ Full Time
                    </span>
                @else
                    <div
                        style="font-size: 1.3rem; font-weight: 800; background: linear-gradient(135deg, #007bff, #00d4ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 12px 0;">
                        VS
                    </div>
                    <span
                        style="background: #fbbf24; color: white; padding: 5px 12px; border-radius: 12px; font-weight: 600; font-size: 0.7rem; display: inline-block;"
                    >
                        ⏳ Upcoming
                    </span>
                @endif

                <div style="margin-top: 12px; font-size: 0.75rem;">
                    <p style="color: white; margin-bottom: 4px;">
                        <i
                            class="far fa-calendar-alt"
                            style="color: {{ $categoryColor }}; margin-right: 4px;"
                        ></i>
                        📅 {{ \Carbon\Carbon::parse($match->date)->format('d M Y') }}
                    </p>
                    <p style="color: white; margin-bottom: 4px;">
                        <i
                            class="far fa-clock"
                            style="color: {{ $categoryColor }}; margin-right: 4px;"
                        ></i>
                        {{ \Carbon\Carbon::parse($match->date)->format('H:i') }} WIB
                    </p>
                    <p style="color: white;">
                        <i
                            class="fas fa-map-marker-alt"
                            style="color: {{ $categoryColor }}; margin-right: 4px;"
                        ></i>
                        📍 {{ $match->venue_name ?? 'TBD' }}
                    </p>
                </div>
            </div>

            <!-- Team 2 -->
            <div style="text-align: center; min-width: 0;">
                <div
                    style="width: 70px; height: 70px; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center;">
                    <img
                        src="{{ $match->team_logo_2 ? asset('storage/' . $match->team_logo_2) : asset('assets/client/images/EXPOSE FC.png') }}"
                        alt="{{ $match->teamname_2 }}"
                        style="max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 123, 255, 0.3));"
                    >
                </div>
                <h3
                    style="color: white; font-size: 0.85rem; font-weight: 700; margin-bottom: 10px; word-wrap: break-word;">
                    {{ $match->teamname_2 }}</h3>

                @if ($goalsTeam2->count() > 0)
                    @foreach ($goalsTeam2 as $goal)
                        <div
                            style="background: rgba(45, 52, 64, 0.6); border-radius: 8px; padding: 8px 12px; margin-bottom: 8px; border-left: 3px solid {{ $categoryColor }}; display: flex; align-items: center; gap: 10px;">
                            @if ($goal->player && $goal->player->photo)
                                <img
                                    src="{{ asset('storage/' . $goal->player->photo) }}"
                                    alt="{{ $goal->player->name }}"
                                    style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 2px solid {{ $categoryColor }}; flex-shrink: 0;"
                                >
                            @else
                                <div
                                    style="width: 30px; height: 30px; border-radius: 50%; background: {{ $categoryColor }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i
                                        class="fas fa-user"
                                        style="color: white; font-size: 0.8rem;"
                                    ></i>
                                </div>
                            @endif
                            <div style="flex: 1; text-align: left;">
                                <p style="color: white; font-weight: 600; font-size: 0.8rem; margin: 0;">
                                    {{ $goal->player->name ?? 'Unknown' }}
                                    @if ($goal->player && $goal->player->number)
                                        <span
                                            style="color: #94a3b8; font-size: 0.7rem;">#{{ $goal->player->number }}</span>
                                    @endif
                                </p>
                                <p style="color: #94a3b8; font-size: 0.7rem; margin: 0;">
                                    ⚽ {{ $goal->minute }}'
                                    @if ($goal->goal_type == 'penalty')
                                        <span
                                            style="background: #fbbf24; color: white; padding: 1px 4px; border-radius: 3px; font-size: 0.6rem; font-weight: 600;"
                                        >(P)</span>
                                    @elseif($goal->goal_type == 'own_goal')
                                        <span
                                            style="background: #ef4444; color: white; padding: 1px 4px; border-radius: 3px; font-size: 0.6rem; font-weight: 600;"
                                        >(OG)</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- TAMBAHKAN empty state untuk no goals -->
                    <div
                        style="background: rgba(45, 52, 64, 0.3); border-radius: 8px; padding: 12px; border: 1px dashed rgba(255, 255, 255, 0.1); text-align: center;">
                        <small style="color: #94a3b8; font-size: 0.7rem;">
                            <i class="fas fa-minus-circle"></i> No goals yet
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div style="margin: 20px 0 0 0;">
    <div style="margin-bottom: 20px;">
        <!-- Head to Head -->
        <div
            style="background: rgba(45, 52, 64, 0.5); border-radius: 12px; padding: 16px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <h4
                style="color: white; font-size: 1.1rem; font-weight: 700; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 3px solid {{ $categoryColor }};">
                Head to Head Record</h4>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 16px;">
                <div
                    style="text-align: center; background: rgba(16, 185, 129, 0.15); padding: 16px 12px; border-radius: 10px; border: 2px solid #10b981;">
                    <div
                        style="font-size: 2.8rem; font-weight: 900; color: #10b981; line-height: 1; letter-spacing: -1px;">
                        {{ $team1Stats['wins'] }}</div>
                    <div
                        style="color: #10b981; font-size: 0.65rem; text-transform: uppercase; font-weight: 700; margin-top: 10px; letter-spacing: 0.5px;">
                        Wins</div>
                    <div style="color: #94a3b8; font-size: 0.65rem; margin-top: 4px;">
                        {{ substr($team1->name ?? 'Team 1', 0, 12) }}</div>
                </div>
                <div
                    style="text-align: center; background: rgba(251, 191, 36, 0.15); padding: 16px 12px; border-radius: 10px; border: 2px solid #fbbf24;">
                    <div
                        style="font-size: 2.8rem; font-weight: 900; color: #fbbf24; line-height: 1; letter-spacing: -1px;">
                        {{ $team1Stats['draws'] }}</div>
                    <div
                        style="color: #fbbf24; font-size: 0.65rem; text-transform: uppercase; font-weight: 700; margin-top: 10px; letter-spacing: 0.5px;">
                        Draws</div>
                </div>
                <div
                    style="text-align: center; background: rgba(239, 68, 68, 0.15); padding: 16px 12px; border-radius: 10px; border: 2px solid #ef4444;">
                    <div
                        style="font-size: 2.8rem; font-weight: 900; color: #ef4444; line-height: 1; letter-spacing: -1px;">
                        {{ $team1Stats['losses'] }}</div>
                    <div
                        style="color: #ef4444; font-size: 0.65rem; text-transform: uppercase; font-weight: 700; margin-top: 10px; letter-spacing: 0.5px;">
                        Losses</div>
                    <div style="color: #94a3b8; font-size: 0.65rem; margin-top: 4px;">
                        {{ substr($team2->name ?? 'Team 2', 0, 12) }}</div>
                </div>
            </div>

            @if ($headToHeadMatches && $headToHeadMatches->count() > 0)
                @foreach ($headToHeadMatches as $h2h)
                    <div
                        style="background: rgba(55, 62, 74, 0.5); border-radius: 8px; padding: 16px; margin-bottom: 12px; border: 1px solid rgba(255, 255, 255, 0.05); display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                        <div
                            style="display: flex; align-items: center; justify-content: space-between; gap: 16px; width: 100%;">
                            <div style="flex: 1; text-align: center; min-width: 0;">
                                <div
                                    style="width: 60px; height: 60px; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center;">
                                    <img
                                        src="{{ $h2h->team1->logo ? asset('storage/' . $h2h->team1->logo) : asset('assets/client/images/EXPOSE FC.png') }}"
                                        alt="{{ $h2h->teamname_1 }}"
                                        style="max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 123, 255, 0.3));"
                                    >
                                </div>
                                <p style="color: #94a3b8; font-size: 0.7rem; margin: 0;">
                                    {{ substr($h2h->teamname_1, 0, 15) }}</p>
                            </div>
                            <div
                                style="flex: 0 0 auto; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px;">
                                <span
                                    style="color: {{ $categoryColor }}; font-weight: 900; font-size: 1.3rem; letter-spacing: -1px;"
                                >{{ $h2h->score_team1 }} - {{ $h2h->score_team2 }}</span>
                                <div style="text-align: center; color: #94a3b8; font-size: 0.65rem;">
                                    {{ \Carbon\Carbon::parse($h2h->date)->format('d M Y') }}</div>
                            </div>
                            <div style="flex: 1; text-align: center; min-width: 0;">
                                <div
                                    style="width: 60px; height: 60px; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center;">
                                    <img
                                        src="{{ $h2h->team2->logo ? asset('storage/' . $h2h->team2->logo) : asset('assets/client/images/EXPOSE FC.png') }}"
                                        alt="{{ $h2h->teamname_2 }}"
                                        style="max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 123, 255, 0.3));"
                                    >
                                </div>
                                <p style="color: #94a3b8; font-size: 0.7rem; margin: 0;">
                                    {{ substr($h2h->teamname_2, 0, 15) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div
                    style="background: rgba(55, 62, 74, 0.3); border-radius: 8px; padding: 16px; border: 1px dashed rgba(255, 255, 255, 0.1);">
                    <p style="color: #94a3b8; text-align: center; font-size: 0.85rem; margin: 0;">📊 No previous
                        meetings between these teams</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Match Details -->
    <div
        style="background: rgba(45, 52, 64, 0.5); border-radius: 12px; padding: 14px; border: 1px solid rgba(255, 255, 255, 0.08);">
        <h4
            style="color: white; font-size: 1rem; font-weight: 700; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 3px solid {{ $categoryColor }};">
            Match Details</h4>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
            <div style="background: rgba(45, 52, 64, 0.4); border-radius: 8px; padding: 10px;">
                <div
                    style="color: #94a3b8; font-size: 0.65rem; text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">
                    Competition</div>
                <div style="color: white; font-size: 0.85rem; font-weight: 600;">{{ $competition->name ?? 'N/A' }}
                </div>
            </div>
            <div style="background: rgba(45, 52, 64, 0.4); border-radius: 8px; padding: 10px;">
                <div
                    style="color: #94a3b8; font-size: 0.65rem; text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">
                    Year</div>
                <div style="color: white; font-size: 0.85rem; font-weight: 600;">{{ $competition->year ?? 'N/A' }}
                </div>
            </div>
            <div style="background: rgba(45, 52, 64, 0.4); border-radius: 8px; padding: 10px;">
                <div
                    style="color: #94a3b8; font-size: 0.65rem; text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">
                    Venue</div>
                <div style="color: white; font-size: 0.85rem; font-weight: 600;">📍 {{ $venue->name ?? 'TBD' }}</div>
            </div>
            <div style="background: rgba(45, 52, 64, 0.4); border-radius: 8px; padding: 10px;">
                <div
                    style="color: #94a3b8; font-size: 0.65rem; text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">
                    Status</div>
                @if ($match->status)
                    <span
                        style="background: #10b981; color: white; padding: 3px 8px; border-radius: 6px; font-weight: 600; font-size: 0.7rem; display: inline-block;"
                    >✓ Completed</span>
                @else
                    <span
                        style="background: #fbbf24; color: white; padding: 3px 8px; border-radius: 6px; font-weight: 600; font-size: 0.7rem; display: inline-block;"
                    >⏳ Scheduled</span>
                @endif
            </div>
        </div>

        @if ($match->link_ticket && !$match->status)
            <div style="text-align: center;">
                <a
                    href="{{ $match->link_ticket }}"
                    target="_blank"
                    style="background: linear-gradient(135deg, {{ $categoryColor }}, {{ $categoryColor }}dd); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.8rem; display: inline-block;"
                >
                    <i class="fas fa-ticket-alt"></i> Get Tickets
                </a>
            </div>
        @endif
    </div>
</div>
