<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Competitions;
use App\Models\Teams;
use App\Models\Venues;
use App\Models\TeamsCompetitions;
use App\Models\MatchGoal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TournamentController extends Controller
{
    /**
     * Display the tournament page for public
     */
    public function index(Request $request)
    {
        $year = $request->year ?? 'all';
        $category = $request->category ?? 'all';
        $event = $request->event ?? 'all';

        // Base query
        $query = Matches::index('');

        // Apply filters
        if ($year !== 'all') {
            $query->where('competitions.year', $year);
        }

        if ($category !== 'all') {
            $query->where('competitions.category', $category);
        }

        if ($event !== 'all') {
            $query->where('competitions.event_type', $event);
        }

        // ⭐ CRITICAL: Load goals relationship
        $matches = $query->with('goals')->orderBy('matches.date', 'desc')->get();

        // Group by category dan event_type
        $groupedMatches = $matches->groupBy(function ($match) {
            return $match->competition_id;
        })->mapWithKeys(function ($group) {
            $firstMatch = $group->first();
            $key = json_encode([
                'category' => $firstMatch->category ?? 'internal',
                'event_type' => $firstMatch->event_type ?? 'Unknown Event'
            ]);
            return [$key => $group];
        });

        // Get unique years
        $years = Matches::join('competitions', 'matches.competition_id', '=', 'competitions.id')
            ->selectRaw('DISTINCT competitions.year')
            ->whereNotNull('competitions.year')
            ->orderBy('competitions.year', 'desc')
            ->pluck('year');

        // Get all unique event types
        $events = Matches::join('competitions', 'matches.competition_id', '=', 'competitions.id')
            ->select('competitions.event_type')
            ->distinct()
            ->orderBy('competitions.event_type')
            ->pluck('event_type');

        return view('client.our-tournament', [
            'groupedMatches' => $groupedMatches,
            'years' => $years,
            'events' => $events,
            'selectedYear' => $year,
            'selectedCategory' => $category,
            'selectedEvent' => $event
        ]);
    }

    /**
     * Filter matches via AJAX
     */
    public function filterMatches(Request $request)
    {
        try {
            $year = $request->input('year', 'all');
            $category = $request->input('category', 'all');
            $event = $request->input('event', 'all');

            $query = Matches::index('');

            // Apply filters
            if ($year !== 'all') {
                $query->where('competitions.year', $year);
            }

            if ($category !== 'all') {
                $query->where('competitions.category', $category);
            }

            if ($event !== 'all') {
                $query->where('competitions.event_type', $event);
            }

            // ⭐ CRITICAL: Load goals relationship
            $matches = $query->with('goals')->orderBy('matches.date', 'desc')->get();

            // Group by category dan event_type
            $groupedMatches = $matches->groupBy(function ($match) {
                return $match->competition_id;
            })->mapWithKeys(function ($group) {
                $firstMatch = $group->first();
                $key = json_encode([
                    'category' => $firstMatch->category ?? 'internal',
                    'event_type' => $firstMatch->event_type ?? 'Unknown Event'
                ]);
                return [$key => $group];
            });

            // Generate HTML content
            $html = '';

            if ($groupedMatches->count() > 0) {
                foreach ($groupedMatches as $groupKey => $matchesInGroup) {
                    $groupData = json_decode($groupKey, true);

                    $categoryColor = match ($groupData['category']) {
                        'internal' => '#007bff',
                        'external' => '#f59e0b',
                        'friendly' => '#10b981',
                        default => '#6b7280',
                    };

                    $html .= $this->renderMatchGroup($groupData, $matchesInGroup, $categoryColor);
                }
            } else {
                $html .= $this->renderEmptyState();
            }

            return response()->json([
                'success' => true,
                'html' => $html
            ]);

        } catch (\Exception $e) {
            \Log::error('Filter Matches Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'html' => '<div class="alert alert-danger" style="margin: 20px; padding: 20px; background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; border-radius: 8px; color: #ef4444;"><p style="margin: 0;"><strong>Error loading matches:</strong> ' . $e->getMessage() . '</p></div>'
            ], 500);
        }
    }

    /**
     * Render match group HTML
     */
    private function renderMatchGroup($groupData, $matchesInGroup, $categoryColor)
    {
        $categoryLabel = match ($groupData['category']) {
            'internal' => 'Internal',
            'external' => 'External',
            'friendly' => 'Friendly',
            default => ucfirst($groupData['category']),
        };

        $html = '<div class="mb-5">';
        $html .= '<div class="section-header-' . $groupData['category'] . '" style="background: linear-gradient(135deg, rgba(' . $this->hexToRgb($categoryColor) . ', 0.1), rgba(' . $this->hexToRgb($categoryColor) . ', 0.05)); border-left: 4px solid ' . $categoryColor . '; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">';
        $html .= '<h4 class="section-header text-white" style="font-weight: 700; font-size: 1.75rem; margin: 0;">';
        $html .= '<span style="color: ' . $categoryColor . '; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">' . $categoryLabel . '</span> - ' . $groupData['event_type'];
        $html .= '</h4></div>';

        foreach ($matchesInGroup as $match) {
            $html .= $this->renderMatchCard($match, $categoryColor);
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Render single match card HTML
     */
    private function renderMatchCard($match, $categoryColor)
    {
        $totalGoals = $match->goals->count();
        $statusBadge = $match->status ? '✓ Selesai' : '⏳ Mendatang';
        $statusColor = $match->status ? '#10b981' : '#fbbf24';

        $html = '<div class="match-card-wrapper">';
        $html .= '<div class="card">';
        $html .= '<div class="card-body">';
        $html .= '<div class="row align-items-center g-2">';

        // Team 1
        $html .= '<div class="col-4 text-center">';
        $html .= '<div class="team-logo-container">';
        $html .= '<img src="' . asset('storage/' . $match->team_logo_1) . '" alt="' . e($match->teamname_1) . '" class="team-logo" onerror="this.src=\'' . asset('assets/client/images/EXPOSE FC.png') . '\'">';
        $html .= '</div>';
        $html .= '<h6 class="team-name">' . e($match->teamname_1) . '</h6>';
        $html .= '</div>';

        // Match Info
        $html .= '<div class="col-4 text-center">';
        $html .= '<span class="badge match-badge text-white d-block mb-2" style="background: ' . $categoryColor . ';">' . strtoupper(e($match->event_type ?? 'EVENT')) . '</span>';

        if ($match->status) {
            $html .= '<h2 class="mb-2 text-white" style="font-size: 1.8rem; font-weight: 800;">' . ($match->score_team1 ?? 0) . ' - ' . ($match->score_team2 ?? 0) . '</h2>';
            if ($totalGoals > 0) {
                $html .= '<small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-bottom: 0.4rem;">⚽ ' . $totalGoals . ' Goal' . ($totalGoals > 1 ? 's' : '') . '</small>';
            }
        } else {
            $html .= '<h2 class="match-vs mb-2">VS</h2>';
        }

        $html .= '<p class="match-time mb-1 text-white"><strong style="font-size: 1.1rem;">' . Carbon::parse($match->date)->format('H:i') . ' WIB</strong></p>';
        $html .= '<p class="match-info-text mb-1">📅 ' . Carbon::parse($match->date)->format('d F Y') . '</p>';
        $html .= '<p class="match-info-text mb-1">🏟️ ' . e($match->venue_name ?? 'TBD') . '</p>';
        $html .= '<small style="color: ' . $statusColor . '; font-weight: 600;">' . $statusBadge . '</small><br>';
        $html .= '<button type="button" class="view-details-btn mt-2" onclick="window.location.href=\'' . route('tournament.match.detail.page', $match->id) . '\'" style="background: ' . $categoryColor . ';">Detail Pertandingan</button>';
        $html .= '</div>';

        // Team 2
        $html .= '<div class="col-4 text-center">';
        $html .= '<div class="team-logo-container">';
        $html .= '<img src="' . asset('storage/' . $match->team_logo_2) . '" alt="' . e($match->teamname_2) . '" class="team-logo" onerror="this.src=\'' . asset('assets/client/images/EXPOSE FC.png') . '\'">';
        $html .= '</div>';
        $html .= '<h6 class="team-name">' . e($match->teamname_2) . '</h6>';
        $html .= '</div>';

        $html .= '</div></div></div></div>';

        return $html;
    }

    /**
     * Render empty state HTML
     */
    private function renderEmptyState()
    {
        return '<div id="emptyState" class="py-5 text-center">' .
            '<div style="font-size: 5rem; opacity: 0.5;">⚽</div>' .
            '<h4 class="mt-4" style="color: #cbd5e1; font-weight: 600;">No Matches Found</h4>' .
            '<p class="text-muted" style="font-size: 1.1rem;">Try adjusting your filters</p>' .
            '</div>';
    }

    /**
     * Calculate form (W/D/L) from recent matches
     */
    private function calculateForm($matches, $teamId)
    {
        $form = [];

        foreach ($matches as $match) {
            $isHome = $match->team_id_1 == $teamId;
            $teamScore = $isHome ? $match->score_team1 : $match->score_team2;
            $opponentScore = $isHome ? $match->score_team2 : $match->score_team1;

            if ($teamScore > $opponentScore) {
                $form[] = 'W';
            } elseif ($teamScore == $opponentScore) {
                $form[] = 'D';
            } else {
                $form[] = 'L';
            }
        }

        return $form;
    }

    /**
     * Helper: Convert HEX to RGB for gradient backgrounds
     */
    private function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return "$r, $g, $b";
    }

    /**
     * Get category label from lowercase
     */
    private function getCategoryLabel($category)
    {
        return match ($category) {
            'internal' => 'Internal',
            'external' => 'External',
            'friendly' => 'Friendly',
            default => ucfirst($category)
        };
    }

    /**
     * Get events by category for dynamic dropdown (AJAX)
     */
    public function getEventsByCategory(Request $request)
    {
        $category = $request->input('category');

        if ($category === 'all') {
            $events = Competitions::select('event_type')
                ->whereHas('matches')
                ->distinct()
                ->orderBy('event_type')
                ->pluck('event_type');
        } else {
            $events = Competitions::select('event_type')
                ->where('category', $category)
                ->whereHas('matches')
                ->distinct()
                ->orderBy('event_type')
                ->pluck('event_type');
        }

        return response()->json([
            'success' => true,
            'events' => $events
        ]);
    }

    /**
     * Get statistics for tournament page (optional - for additional info)
     */
    public function getStatistics()
    {
        $totalMatches = Matches::count();
        $completedMatches = Matches::where('status', Matches::STATUS_FINISHED)->count();
        $upcomingMatches = Matches::where('status', Matches::STATUS_SCHEDULED)
            ->where('date', '>', Carbon::now())
            ->count();
        $totalCompetitions = Competitions::whereHas('matches')->count();

        return response()->json([
            'success' => true,
            'statistics' => [
                'total_matches' => $totalMatches,
                'completed_matches' => $completedMatches,
                'upcoming_matches' => $upcomingMatches,
                'total_competitions' => $totalCompetitions
            ]
        ]);
    }

    /**
     * Calculate standings for a competition
     * Fetches teams from teams_competitions table
     */
    private function calculateStandings($competitionId)
    {
        // ⭐ Ambil semua tim yang terdaftar di kompetisi dari teams_competitions
        $teamsInCompetition = TeamsCompetitions::where('competition_id', $competitionId)
            ->with('team')
            ->get();

        $standings = [];

        foreach ($teamsInCompetition as $teamCompetition) {
            $team = $teamCompetition->team;

            if (!$team) {
                continue;
            }

            $teamId = $team->id;

            // Ambil hanya match yang SUDAH SELESAI untuk hitung statistik
            $matches = Matches::where('competition_id', $competitionId)
                ->where('status', Matches::STATUS_FINISHED)
                ->where(function ($query) use ($teamId) {
                    $query->where('team_id_1', $teamId)
                        ->orWhere('team_id_2', $teamId);
                })
                ->get();

            // ⭐ DEFAULT: Semua statistik dimulai dari 0
            $stats = [
                'team_id' => $teamId,
                'team' => $team,
                'matches_played' => 0,
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'goals_for' => 0,
                'goals_against' => 0,
                'goal_difference' => 0,
                'points' => 0
            ];

            // Hitung statistik HANYA jika ada match yang sudah selesai
            if ($matches->count() > 0) {
                $stats['matches_played'] = $matches->count();

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
            }

            $standings[] = (object) $stats;
        }

        // Sort standings: Points > Goal Difference > Goals For
        usort($standings, function ($a, $b) {
            if ($b->points != $a->points) {
                return $b->points - $a->points;
            }
            if ($b->goal_difference != $a->goal_difference) {
                return $b->goal_difference - $a->goal_difference;
            }
            return $b->goals_for - $a->goals_for;
        });

        return $standings;
    }

    /**
     * Show match detail page with standings
     */
    public function showMatchDetail($id)
    {
        try {
            // Update match statuses
            Matches::updateMatchStatuses();

            // Get match detail with all relations
            $match = Matches::index('')
                ->where('matches.id', $id)
                ->firstOrFail();

            // Get competition details
            $competition = Competitions::find($match->competition_id);

            // Get team details
            $team1 = Teams::find($match->team_id_1);
            $team2 = Teams::find($match->team_id_2);

            // Get venue details
            $venue = Venues::find($match->venue_id);

            // Get goal scorers for this match
            $goalsTeam1 = MatchGoal::where('match_id', $id)
                ->where('team_id', $match->team_id_1)
                ->with('player')
                ->orderBy('minute')
                ->get();

            $goalsTeam2 = MatchGoal::where('match_id', $id)
                ->where('team_id', $match->team_id_2)
                ->with('player')
                ->orderBy('minute')
                ->get();

            // Get head to head statistics - Last 5 completed matches
            $headToHeadMatches = Matches::where(function ($query) use ($match) {
                $query->where(function ($q) use ($match) {
                    $q->where('team_id_1', $match->team_id_1)
                        ->where('team_id_2', $match->team_id_2);
                })->orWhere(function ($q) use ($match) {
                    $q->where('team_id_1', $match->team_id_2)
                        ->where('team_id_2', $match->team_id_1);
                });
            })
                ->where('matches.id', '!=', $id)
                ->where('status', Matches::STATUS_FINISHED)
                ->orderBy('date', 'desc')
                ->limit(5)
                ->with(['team1', 'team2'])
                ->get();

            // Calculate head to head statistics
            $team1Stats = [
                'wins' => 0,
                'draws' => 0,
                'losses' => 0
            ];

            foreach ($headToHeadMatches as $h2h) {
                if ($h2h->team_id_1 == $match->team_id_1) {
                    if ($h2h->score_team1 > $h2h->score_team2) {
                        $team1Stats['wins']++;
                    } elseif ($h2h->score_team1 == $h2h->score_team2) {
                        $team1Stats['draws']++;
                    } else {
                        $team1Stats['losses']++;
                    }
                } else {
                    if ($h2h->score_team2 > $h2h->score_team1) {
                        $team1Stats['wins']++;
                    } elseif ($h2h->score_team1 == $h2h->score_team2) {
                        $team1Stats['draws']++;
                    } else {
                        $team1Stats['losses']++;
                    }
                }
            }

            // Get recent form (Last 5 completed matches)
            $team1RecentMatches = Matches::where(function ($query) use ($match) {
                $query->where('team_id_1', $match->team_id_1)
                    ->orWhere('team_id_2', $match->team_id_1);
            })
                ->where('matches.id', '!=', $id)
                ->where('status', Matches::STATUS_FINISHED)
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get();

            $team2RecentMatches = Matches::where(function ($query) use ($match) {
                $query->where('team_id_1', $match->team_id_2)
                    ->orWhere('team_id_2', $match->team_id_2);
            })
                ->where('matches.id', '!=', $id)
                ->where('status', Matches::STATUS_FINISHED)
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get();

            $team1Form = $this->calculateForm($team1RecentMatches, $match->team_id_1);
            $team2Form = $this->calculateForm($team2RecentMatches, $match->team_id_2);

            // ⭐ Calculate standings for this competition
            $standings = $this->calculateStandings($match->competition_id);

            // Return view untuk full page detail
            return view('client.our-tournament.tournament-detail', [
                'match' => $match,
                'competition' => $competition,
                'team1' => $team1,
                'team2' => $team2,
                'venue' => $venue,
                'goalsTeam1' => $goalsTeam1,
                'goalsTeam2' => $goalsTeam2,
                'headToHeadMatches' => $headToHeadMatches,
                'team1Stats' => $team1Stats,
                'team1Form' => $team1Form,
                'team2Form' => $team2Form,
                'standings' => $standings,
            ]);

        } catch (\Exception $e) {
            abort(404, 'Match not found');
        }
    }

    /**
     * Get match detail for modal (without standings)
     */
    public function getMatchDetailModal($id)
    {
        try {
            // Update match statuses
            Matches::updateMatchStatuses();

            // Get match detail with all relations
            $match = Matches::index('')
                ->where('matches.id', $id)
                ->firstOrFail();

            // Get competition details
            $competition = Competitions::find($match->competition_id);

            // Get team details
            $team1 = Teams::find($match->team_id_1);
            $team2 = Teams::find($match->team_id_2);

            // Get venue details
            $venue = Venues::find($match->venue_id);

            // Get goal scorers for this match
            $goalsTeam1 = MatchGoal::where('match_id', $id)
                ->where('team_id', $match->team_id_1)
                ->with('player')
                ->orderBy('minute')
                ->get();

            $goalsTeam2 = MatchGoal::where('match_id', $id)
                ->where('team_id', $match->team_id_2)
                ->with('player')
                ->orderBy('minute')
                ->get();

            // Get head to head statistics - Last 5 completed matches
            $headToHeadMatches = Matches::where(function ($query) use ($match) {
                $query->where(function ($q) use ($match) {
                    $q->where('team_id_1', $match->team_id_1)
                        ->where('team_id_2', $match->team_id_2);
                })->orWhere(function ($q) use ($match) {
                    $q->where('team_id_1', $match->team_id_2)
                        ->where('team_id_2', $match->team_id_1);
                });
            })
                ->where('matches.id', '!=', $id)
                ->where('status', Matches::STATUS_FINISHED)
                ->orderBy('date', 'desc')
                ->limit(5)
                ->with(['team1', 'team2'])
                ->get();

            // Calculate head to head statistics
            $team1Stats = [
                'wins' => 0,
                'draws' => 0,
                'losses' => 0
            ];

            foreach ($headToHeadMatches as $h2h) {
                if ($h2h->team_id_1 == $match->team_id_1) {
                    if ($h2h->score_team1 > $h2h->score_team2) {
                        $team1Stats['wins']++;
                    } elseif ($h2h->score_team1 == $h2h->score_team2) {
                        $team1Stats['draws']++;
                    } else {
                        $team1Stats['losses']++;
                    }
                } else {
                    if ($h2h->score_team2 > $h2h->score_team1) {
                        $team1Stats['wins']++;
                    } elseif ($h2h->score_team1 == $h2h->score_team2) {
                        $team1Stats['draws']++;
                    } else {
                        $team1Stats['losses']++;
                    }
                }
            }

            // Get recent form (Last 5 completed matches)
            $team1RecentMatches = Matches::where(function ($query) use ($match) {
                $query->where('team_id_1', $match->team_id_1)
                    ->orWhere('team_id_2', $match->team_id_1);
            })
                ->where('matches.id', '!=', $id)
                ->where('status', Matches::STATUS_FINISHED)
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get();

            $team2RecentMatches = Matches::where(function ($query) use ($match) {
                $query->where('team_id_1', $match->team_id_2)
                    ->orWhere('team_id_2', $match->team_id_2);
            })
                ->where('matches.id', '!=', $id)
                ->where('status', Matches::STATUS_FINISHED)
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get();

            $team1Form = $this->calculateForm($team1RecentMatches, $match->team_id_1);
            $team2Form = $this->calculateForm($team2RecentMatches, $match->team_id_2);

            return view('client.match-detail-modal', [
                'match' => $match,
                'competition' => $competition,
                'team1' => $team1,
                'team2' => $team2,
                'venue' => $venue,
                'goalsTeam1' => $goalsTeam1,
                'goalsTeam2' => $goalsTeam2,
                'headToHeadMatches' => $headToHeadMatches,
                'team1Stats' => $team1Stats,
                'team1Form' => $team1Form,
                'team2Form' => $team2Form,
            ]);

        } catch (\Exception $e) {
            return response()->view('errors.404', [], 404);
        }
    }

    /**
     * Close modal and return success response
     */
    public function closeModal(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Modal closed successfully'
        ]);
    }
}