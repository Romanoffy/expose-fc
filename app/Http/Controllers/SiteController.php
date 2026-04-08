<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Blogs;
use App\Models\Videos;
use App\Models\Matches;
use App\Models\Events;
use App\Models\Merchandise;
use App\Models\Players;
use App\Models\Slider;
use App\Models\Teams;
use App\Models\Standings;
use App\Models\Competitions;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $sliders = Slider::where('status', 'Aktif')->get();
        $limit = $request->limit ?? 20;
        $search = $request->search ?? null;

        // ✅ UPDATED: Get competition with most recent schedule (tanggal_mulai)
        $firstCompetition = Competitions::orderBy('tanggal_mulai', 'desc')
            ->first();

        // Calculate standings for the competition with most recent matches
        $homeStandings = null;
        if ($firstCompetition) {
            $homeStandings = $this->calculateStandings($firstCompetition->id);
        }

        // Get latest finished match
        $latestFinishedMatch = Matches::index($search)
            ->where('status', Matches::STATUS_FINISHED)
            ->orderBy('date', 'desc')
            ->with('goals')
            ->first();

        // Get next upcoming match
        $nextUpcomingMatch = Matches::index($search)
            ->where('status', Matches::STATUS_SCHEDULED)
            ->where('date', '>', Carbon::now())
            ->orderBy('date', 'asc')
            ->first();

        return view('client.index', [
            'sliders' => $sliders,
            'news_array' => News::index($search, 1)->paginate($limit),
            'blogs_array' => Blogs::index($search)->paginate($limit),
            'video_array' => Videos::index($search)->paginate($limit),
            'latestFinishedMatch' => $latestFinishedMatch,
            'nextUpcomingMatch' => $nextUpcomingMatch,
            'event_array' => Events::index($search)->orderBy('tanggal_mulai', 'desc')->limit(3)->get(),
            'team_array' => Teams::index($search)->paginate(),
            'player_array' => Players::index($search)->paginate($limit),
            'firstCompetition' => $firstCompetition,
            'homeStandings' => $homeStandings,
            'limit' => $limit,
            'search' => $search,
            'teams' => Teams::all(),
        ]);
    }

    /**
     * Calculate standings for a competition - FIXED VERSION
     * Shows ALL registered teams including those who haven't played yet
     */
    private function calculateStandings($competitionId)
    {
        // PRIORITAS 1: Get teams from teams_competitions table (registered teams)
        $teamIds = \App\Models\TeamsCompetitions::where('competition_id', $competitionId)
            ->pluck('team_id')
            ->unique();

        // FALLBACK: If no teams in teams_competitions, get from matches
        if ($teamIds->isEmpty()) {
            $teamIds = Matches::where('competition_id', $competitionId)
                ->whereIn('status', [Matches::STATUS_SCHEDULED, Matches::STATUS_FINISHED])
                ->get()
                ->flatMap(function ($match) {
                    return [$match->team_id_1, $match->team_id_2];
                })
                ->unique()
                ->values();
        }

        $standings = [];

        foreach ($teamIds as $teamId) {
            $team = Teams::find($teamId);
            if (!$team)
                continue;

            // Get only FINISHED matches to calculate statistics
            $matches = Matches::where('competition_id', $competitionId)
                ->where('status', Matches::STATUS_FINISHED)
                ->where(function ($query) use ($teamId) {
                    $query->where('team_id_1', $teamId)
                        ->orWhere('team_id_2', $teamId);
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
                'points' => 0
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
}