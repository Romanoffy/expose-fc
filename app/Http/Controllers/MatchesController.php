<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Competitions;
use App\Models\Teams;
use App\Models\Venues;
use App\Models\TeamsCompetitions;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;

class MatchesController extends Controller
{
    public function __construct()
    {
        $this->middleware('isadmin')->except(['matchsite']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Update status otomatis sebelum menampilkan
        Matches::updateMatchStatuses();

        $limit = $request->limit ?? 10;
        $search = $request->search ?? null;

        // Build query dengan filter
        $query = Matches::index($search);

        // Filter by competition
        if ($request->filled('competition')) {
            $query->where('competition_id', $request->competition);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by venue
        if ($request->filled('venue')) {
            $query->where('venue_id', $request->venue);
        }

        // Get all competitions and venues for filter dropdowns
        $competitions = Competitions::orderBy('name')->get();
        $venues = Venues::orderBy('name')->get();

        $matches = $query->paginate($limit);

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.matches.partials.table-rows', ['matches' => $matches])->render(),
                'pagination' => view('admin.matches.partials.pagination', ['matches' => $matches])->render(),
                'total' => $matches->total(),
                'from' => $matches->firstItem() ?? 0,
                'to' => $matches->lastItem() ?? 0
            ]);
        }

        return view('admin.matches.index', [
            'matches_array' => $matches,
            'matches' => $matches,
            'competitions' => $competitions,
            'venues' => $venues,
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Public match site view
     */
    public function matchsite(Request $request)
    {
        Matches::updateMatchStatuses();

        $limit = $request->limit ?? 1;
        $search = $request->search ?? null;

        return view('client.matches', [
            'matches_array' => Matches::index($search)
                ->orderBy('date', 'desc')
                ->where('status', Matches::STATUS_FINISHED)
                ->where('date', '<', Carbon::now())
                ->limit(1)
                ->get(),
            'next_matches_array' => Matches::index($search)
                ->orderBy('date', 'asc')
                // ->where('status', Matches::STATUS_SCHEDULED)
                ->where('date', '>', Carbon::now())
                ->limit(1)
                ->get(),
            'upcoming_matches_array' => Matches::index($search)
                ->orderBy('date', 'asc')
                // ->where('status', Matches::STATUS_SCHEDULED)
                ->where('date', '>', Carbon::now())
                ->get(),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.matches.create', [
            'competitions' => Competitions::orderBy('name')->get(),
            'teams' => [], // Kosongkan, akan diisi via AJAX
            'venues' => Venues::orderBy('name')->get()
        ]);
    }

    /**
     * Get teams by competition (AJAX endpoint)
     */
    public function getTeamsByCompetition($competitionId)
    {
        try {
            $teams = Teams::select('teams.*')
                ->join('teams_competitions', 'teams.id', '=', 'teams_competitions.team_id')
                ->where('teams_competitions.competition_id', $competitionId)
                ->orderBy('teams.name')
                ->get();

            return response()->json([
                'success' => true,
                'teams' => $teams
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching teams: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'team_id_1' => 'required|exists:teams,id',
            'team_id_2' => 'required|exists:teams,id|different:team_id_1',
            'score_team1' => 'nullable|integer|min:0',
            'score_team2' => 'nullable|integer|min:0',
            'winner_team_id' => 'nullable|exists:teams,id',
            'date' => 'required|date',
            'venue_id' => 'required|exists:venues,id',
            'link_ticket' => 'nullable|url',
            'status' => 'nullable|in:0,1,2'
        ], [
            'competition_id.required' => 'Kompetisi wajib dipilih',
            'competition_id.exists' => 'Kompetisi tidak valid',
            'team_id_1.required' => 'Tim Home wajib dipilih',
            'team_id_1.exists' => 'Tim Home tidak valid',
            'team_id_2.required' => 'Tim Away wajib dipilih',
            'team_id_2.exists' => 'Tim Away tidak valid',
            'team_id_2.different' => 'Tim Home dan Away harus berbeda',
            'date.required' => 'Tanggal pertandingan wajib diisi',
            'date.date' => 'Format tanggal tidak valid',
            'venue_id.required' => 'Venue wajib dipilih',
            'venue_id.exists' => 'Venue tidak valid',
            'link_ticket.url' => 'Format URL tidak valid',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            DB::beginTransaction();

            // Validasi tambahan: pastikan kedua tim terdaftar dalam kompetisi
            $team1InCompetition = TeamsCompetitions::where('competition_id', $validated['competition_id'])
                ->where('team_id', $validated['team_id_1'])
                ->exists();

            $team2InCompetition = TeamsCompetitions::where('competition_id', $validated['competition_id'])
                ->where('team_id', $validated['team_id_2'])
                ->exists();

            if (!$team1InCompetition || !$team2InCompetition) {
                throw new \Exception('Tim yang dipilih tidak terdaftar dalam kompetisi ini');
            }

            // Get team details
            $team1 = Teams::findOrFail($validated['team_id_1']);
            $team2 = Teams::findOrFail($validated['team_id_2']);

            // Prepare match data
            $matchData = [
                'competition_id' => $validated['competition_id'],
                'team_id_1' => $validated['team_id_1'],
                'team_id_2' => $validated['team_id_2'],
                'teamname_1' => $team1->name,
                'teamname_2' => $team2->name,
                'team_logo_1' => $team1->logo,
                'team_logo_2' => $team2->logo,
                'score_team1' => $validated['score_team1'] ?? 0,
                'score_team2' => $validated['score_team2'] ?? 0,
                'winner_team_id' => ($validated['winner_team_id'] ?? null) == 0 ? null : ($validated['winner_team_id'] ?? null),
                'date' => $validated['date'],
                'venue_id' => $validated['venue_id'],
                'link_ticket' => $validated['link_ticket'] ?? null,
            ];

            // Set status: manual override atau auto-calculate
            if ($request->filled('status')) {
                $matchData['status'] = $validated['status'];
            } else {
                // Auto-calculate status based on date
                $matchDate = Carbon::parse($validated['date']);
                $now = Carbon::now('Asia/Jakarta');

                if ($now->lt($matchDate)) {
                    $matchData['status'] = Matches::STATUS_SCHEDULED;
                } elseif ($now->gte($matchDate) && $now->lt($matchDate->copy()->addMinutes(105))) {
                    $matchData['status'] = Matches::STATUS_LIVE;
                } else {
                    $matchData['status'] = Matches::STATUS_FINISHED;
                }
            }

            $match = Matches::create($matchData);

            DB::commit();

            return redirect('admin/matches')
                ->with('success', 'Pertandingan berhasil dibuat! Status: ' . $match->status_label);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Match creation error: ' . $e->getMessage());

            return redirect('admin/matches/create')
                ->with('error', 'Pertandingan gagal dibuat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $match = Matches::with(['competition', 'team1', 'team2', 'winner', 'venue', 'goals'])
    //         ->findOrFail($id);

    //     return view('admin.matches.show', [
    //         'match' => $match
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $match = Matches::findOrFail($id);

        // Get teams yang terdaftar dalam kompetisi ini
        $teams = Teams::select('teams.*')
            ->join('teams_competitions', 'teams.id', '=', 'teams_competitions.team_id')
            ->where('teams_competitions.competition_id', $match->competition_id)
            ->orderBy('teams.name')
            ->get();

        return view('admin.matches.edit', [
            'matches_array' => $match,
            'competitions' => Competitions::orderBy('name')->get(),
            'teams' => $teams,
            'venues' => Venues::orderBy('name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $match = Matches::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'team_id_1' => 'required|exists:teams,id',
            'team_id_2' => 'required|exists:teams,id|different:team_id_1',
            'winner_team_id' => 'nullable|exists:teams,id',
            'date' => 'required|date',
            'venue_id' => 'required|exists:venues,id',
            'link_ticket' => 'nullable|url',
            'status' => 'nullable|in:0,1,2'
        ], [
            'competition_id.required' => 'Kompetisi wajib dipilih',
            'team_id_1.required' => 'Tim Home wajib dipilih',
            'team_id_2.required' => 'Tim Away wajib dipilih',
            'team_id_2.different' => 'Tim Home dan Away harus berbeda',
            'date.required' => 'Tanggal pertandingan wajib diisi',
            'venue_id.required' => 'Venue wajib dipilih',
        ]);

        try {
            DB::beginTransaction();

            // Validasi tambahan: pastikan kedua tim terdaftar dalam kompetisi
            $team1InCompetition = TeamsCompetitions::where('competition_id', $validated['competition_id'])
                ->where('team_id', $validated['team_id_1'])
                ->exists();

            $team2InCompetition = TeamsCompetitions::where('competition_id', $validated['competition_id'])
                ->where('team_id', $validated['team_id_2'])
                ->exists();

            if (!$team1InCompetition || !$team2InCompetition) {
                throw new \Exception('Tim yang dipilih tidak terdaftar dalam kompetisi ini');
            }

            // Get team details
            $team1 = Teams::findOrFail($validated['team_id_1']);
            $team2 = Teams::findOrFail($validated['team_id_2']);

            // Update match data (WITHOUT SCORE - will be calculated from goals)
            $matchData = [
                'competition_id' => $validated['competition_id'],
                'team_id_1' => $validated['team_id_1'],
                'team_id_2' => $validated['team_id_2'],
                'teamname_1' => $team1->name,
                'teamname_2' => $team2->name,
                'team_logo_1' => $team1->logo,
                'team_logo_2' => $team2->logo,
                'winner_team_id' => ($validated['winner_team_id'] ?? null) == 0 ? null : ($validated['winner_team_id'] ?? null),
                'date' => $validated['date'],
                'venue_id' => $validated['venue_id'],
                'link_ticket' => $validated['link_ticket'] ?? null,
            ];

            // Set status: manual override atau keep existing
            if ($request->filled('status')) {
                $matchData['status'] = $validated['status'];
            }

            $match->update($matchData);

            // Re-calculate score from goals after update
            $this->recalculateMatchScore($id);

            DB::commit();

            return redirect('admin/matches')
                ->with('success', 'Pertandingan berhasil diupdate! Score dikalkulasi dari goals.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Match update error: ' . $e->getMessage());

            return redirect('admin/matches/' . $id . '/edit')
                ->with('error', 'Pertandingan gagal diupdate: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $match = Matches::findOrFail($id);
            $matchName = $match->teamname_1 . ' vs ' . $match->teamname_2;

            // Delete related goals first
            $match->goals()->delete();

            // Delete match
            $match->delete();

            DB::commit();

            return redirect('admin/matches')
                ->with('success', "Pertandingan '{$matchName}' berhasil dihapus!");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Match deletion error: ' . $e->getMessage());

            return redirect('admin/matches')
                ->with('error', 'Pertandingan gagal dihapus: ' . $e->getMessage());
        }
    }

    /**
     * Get match statistics (API endpoint)
     */
    public function getStatistics($id)
    {
        try {
            $match = Matches::with(['goals.player', 'team1', 'team2'])
                ->findOrFail($id);

            $stats = [
                'total_goals' => $match->goals->count(),
                'team1_goals' => $match->goals->where('team_id', $match->team_id_1)->count(),
                'team2_goals' => $match->goals->where('team_id', $match->team_id_2)->count(),
                'scorers' => $match->goals->groupBy('player_id')->map(function ($goals) {
                    return [
                        'player' => $goals->first()->player->name,
                        'goals' => $goals->count()
                    ];
                })->values()
            ];

            return response()->json([
                'success' => true,
                'statistics' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Recalculate match score from goals
     */
    private function recalculateMatchScore($matchId)
    {
        $match = Matches::findOrFail($matchId);

        // Count regular goals for Team 1
        $team1Goals = \App\Models\MatchGoal::where('match_id', $matchId)
            ->where('team_id', $match->team_id_1)
            ->where('goal_type', '!=', 'own_goal')
            ->count();

        // Count regular goals for Team 2
        $team2Goals = \App\Models\MatchGoal::where('match_id', $matchId)
            ->where('team_id', $match->team_id_2)
            ->where('goal_type', '!=', 'own_goal')
            ->count();

        // Count own goals
        $team1OwnGoals = \App\Models\MatchGoal::where('match_id', $matchId)
            ->where('team_id', $match->team_id_1)
            ->where('goal_type', 'own_goal')
            ->count();

        $team2OwnGoals = \App\Models\MatchGoal::where('match_id', $matchId)
            ->where('team_id', $match->team_id_2)
            ->where('goal_type', 'own_goal')
            ->count();

        // Calculate final scores
        $finalScoreTeam1 = $team1Goals + $team2OwnGoals;
        $finalScoreTeam2 = $team2Goals + $team1OwnGoals;

        // Update match scores
        $match->score_team1 = $finalScoreTeam1;
        $match->score_team2 = $finalScoreTeam2;

        // Auto-determine winner
        if ($finalScoreTeam1 > $finalScoreTeam2) {
            $match->winner_team_id = $match->team_id_1;
        } elseif ($finalScoreTeam2 > $finalScoreTeam1) {
            $match->winner_team_id = $match->team_id_2;
        } else {
            $match->winner_team_id = null; // Draw
        }

        $match->save();

        return $match;
    }
}