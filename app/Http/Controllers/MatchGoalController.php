<?php

namespace App\Http\Controllers;

use App\Models\MatchGoal;
use App\Models\Matches;
use App\Models\Players;
use Illuminate\Http\Request;
use Auth;
use DB;

class MatchGoalController extends Controller
{
    public function __construct()
    {
        $this->middleware('isadmin');
    }

    /**
     * Display goals for all matches or specific match
     */
    public function index(Request $request)
    {
        $matchId = $request->match_id;

        if ($matchId) {
            // Mode detail: tampilkan goal untuk satu pertandingan
            $match = Matches::with(['team1', 'team2', 'venue'])->findOrFail($matchId);
            $goals = MatchGoal::where('match_id', $matchId)
                ->with(['player', 'team'])
                ->orderBy('minute')
                ->get();

            return view('admin.match_goals.index', [
                'match' => $match,
                'goals' => $goals
            ]);
        } else {
            // Mode daftar: tampilkan semua pertandingan dengan filter
            $search = $request->search;
            $competition = $request->competition;
            $status = $request->status;

            $query = Matches::with(['team1', 'team2', 'goals', 'competition', 'venue']);

            // Apply search filter
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('teamname_1', 'like', "%{$search}%")
                        ->orWhere('teamname_2', 'like', "%{$search}%");
                });
            }

            // Apply competition filter
            if ($competition) {
                $query->where('competition_id', $competition);
            }

            // Apply status filter
            if ($status !== null && $status !== '') {
                $query->where('status', $status);
            }

            $matches = $query->orderBy('date', 'desc')->paginate(15);

            // If AJAX request, return JSON with partial views
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.match_goals.partials.table-rows', compact('matches'))->render(),
                    'pagination' => $matches->hasPages() ? view('admin.match_goals.partials.pagination', compact('matches'))->render() : '',
                    'total' => $matches->total(),
                    'from' => $matches->firstItem() ?? 0,
                    'to' => $matches->lastItem() ?? 0
                ]);
            }

            return view('admin.match_goals.list', [
                'matches' => $matches,
                'search' => $search
            ]);
        }
    }

    /**
     * Show form to add goal
     */
    public function create(Request $request)
    {
        $matchId = $request->match_id;

        if (!$matchId) {
            return redirect()->route('match_goals.index')
                ->with('error', 'Silakan pilih pertandingan terlebih dahulu');
        }

        $match = Matches::with(['team1', 'team2', 'venue'])->findOrFail($matchId);

        // IMPROVEMENT: Order players by name and filter active players
        $team1Players = Players::where('team_id', $match->team_id_1)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $team2Players = Players::where('team_id', $match->team_id_2)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.match_goals.create', [
            'match' => $match,
            'team1Players' => $team1Players,
            'team2Players' => $team2Players
        ]);
    }

    /**
     * Store a new goal and auto-update match score
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'match_id' => 'required|exists:matches,id',
            'player_id' => 'required|exists:players,id',
            'team_id' => 'required|exists:teams,id',
            'minute' => 'required|integer|min:1|max:120',
            'goal_type' => 'required|in:regular,penalty,own_goal'
        ], [
            'match_id.required' => 'Pertandingan harus dipilih',
            'match_id.exists' => 'Pertandingan tidak valid',
            'player_id.required' => 'Pemain harus dipilih',
            'player_id.exists' => 'Pemain tidak valid',
            'team_id.required' => 'Tim harus dipilih',
            'team_id.exists' => 'Tim tidak valid',
            'minute.required' => 'Menit harus diisi',
            'minute.integer' => 'Menit harus berupa angka',
            'minute.min' => 'Menit minimal 1',
            'minute.max' => 'Menit maksimal 120',
            'goal_type.required' => 'Jenis goal harus dipilih',
            'goal_type.in' => 'Jenis goal tidak valid'
        ]);

        try {
            DB::beginTransaction();

            // IMPROVEMENT: Validate player belongs to selected team
            $player = Players::findOrFail($validated['player_id']);
            if ($player->team_id != $validated['team_id']) {
                throw new \Exception('Pemain tidak termasuk dalam tim yang dipilih');
            }

            // Create goal
            MatchGoal::create($validated);

            // Auto-update match score
            $this->updateMatchScore($validated['match_id']);

            DB::commit();

            return redirect()->route('match_goals.index', ['match_id' => $validated['match_id']])
                ->with('success', 'Goal berhasil ditambahkan! Score pertandingan terupdate: ' .
                    $this->getMatchScores($validated['match_id']));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Goal creation error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Goal gagal ditambahkan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show form to edit goal
     */
    public function edit(string $id)
    {
        $goal = MatchGoal::with(['player', 'team', 'match'])->findOrFail($id);
        $match = $goal->match;

        $team1Players = Players::where('team_id', $match->team_id_1)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $team2Players = Players::where('team_id', $match->team_id_2)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.match_goals.edit', [
            'match' => $match,
            'goal' => $goal,
            'team1Players' => $team1Players,
            'team2Players' => $team2Players
        ]);
    }

    /**
     * Update goal and auto-update match score
     */
    public function update(Request $request, string $id)
    {
        $goal = MatchGoal::findOrFail($id);

        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'team_id' => 'required|exists:teams,id',
            'minute' => 'required|integer|min:1|max:120',
            'goal_type' => 'required|in:regular,penalty,own_goal'
        ], [
            'player_id.required' => 'Pemain harus dipilih',
            'player_id.exists' => 'Pemain tidak valid',
            'team_id.required' => 'Tim harus dipilih',
            'team_id.exists' => 'Tim tidak valid',
            'minute.required' => 'Menit harus diisi',
            'minute.integer' => 'Menit harus berupa angka',
            'minute.min' => 'Menit minimal 1',
            'minute.max' => 'Menit maksimal 120',
            'goal_type.required' => 'Jenis goal harus dipilih',
            'goal_type.in' => 'Jenis goal tidak valid'
        ]);

        try {
            DB::beginTransaction();

            // IMPROVEMENT: Validate player belongs to selected team
            $player = Players::findOrFail($validated['player_id']);
            if ($player->team_id != $validated['team_id']) {
                throw new \Exception('Pemain tidak termasuk dalam tim yang dipilih');
            }

            $goal->update($validated);

            // Auto-update match score
            $this->updateMatchScore($goal->match_id);

            DB::commit();

            return redirect()->route('match_goals.index', ['match_id' => $goal->match_id])
                ->with('success', 'Goal berhasil diupdate! Score pertandingan terupdate: ' .
                    $this->getMatchScores($goal->match_id));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Goal update error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Goal gagal diupdate: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete goal and auto-update match score
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $goal = MatchGoal::findOrFail($id);
            $matchId = $goal->match_id;
            $playerName = $goal->player->name ?? 'Unknown';
            $minute = $goal->minute;

            $goal->delete();

            // Auto-update match score
            $this->updateMatchScore($matchId);

            DB::commit();

            return redirect()->route('match_goals.index', ['match_id' => $matchId])
                ->with('success', "Goal {$playerName} ({$minute}') berhasil dihapus! Score pertandingan terupdate: " .
                    $this->getMatchScores($matchId));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Goal deletion error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Goal gagal dihapus: ' . $e->getMessage());
        }
    }

    /**
     * AUTO-UPDATE MATCH SCORE - CRITICAL METHOD
     */
    private function updateMatchScore($matchId)
    {
        try {
            $match = Matches::findOrFail($matchId);

            // Count regular goals for Team 1
            $team1Goals = MatchGoal::where('match_id', $matchId)
                ->where('team_id', $match->team_id_1)
                ->where('goal_type', '!=', 'own_goal')
                ->count();

            // Count regular goals for Team 2
            $team2Goals = MatchGoal::where('match_id', $matchId)
                ->where('team_id', $match->team_id_2)
                ->where('goal_type', '!=', 'own_goal')
                ->count();

            // Count own goals (Team 1 scoring own goal benefits Team 2)
            $team1OwnGoals = MatchGoal::where('match_id', $matchId)
                ->where('team_id', $match->team_id_1)
                ->where('goal_type', 'own_goal')
                ->count();

            // Count own goals (Team 2 scoring own goal benefits Team 1)
            $team2OwnGoals = MatchGoal::where('match_id', $matchId)
                ->where('team_id', $match->team_id_2)
                ->where('goal_type', 'own_goal')
                ->count();

            // Calculate final scores
            $finalScoreTeam1 = $team1Goals + $team2OwnGoals;
            $finalScoreTeam2 = $team2Goals + $team1OwnGoals;

            // Debug logging
            \Log::info('=== SCORE UPDATE ===', [
                'match_id' => $matchId,
                'team1_id' => $match->team_id_1,
                'team2_id' => $match->team_id_2,
                'team1_goals' => $team1Goals,
                'team2_goals' => $team2Goals,
                'team1_own_goals' => $team1OwnGoals,
                'team2_own_goals' => $team2OwnGoals,
                'final_score_team1' => $finalScoreTeam1,
                'final_score_team2' => $finalScoreTeam2,
            ]);

            // Update match
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

            // Save to database
            $saved = $match->save();

            if ($saved) {
                \Log::info('Score saved successfully!', [
                    'score_team1' => $match->score_team1,
                    'score_team2' => $match->score_team2,
                    'winner_id' => $match->winner_team_id
                ]);
            } else {
                \Log::error('Failed to save score!');
            }

        } catch (\Exception $e) {
            \Log::error('Error updating match score: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Helper: Get match scores for display
     */
    private function getMatchScores($matchId)
    {
        $match = Matches::find($matchId);
        return $match ? $match->score_team1 . '-' . $match->score_team2 : 'N/A';
    }

    /**
     * API ENDPOINT: Get match score real-time
     */
    public function getMatchScore($matchId)
    {
        try {
            $match = Matches::with(['team1', 'team2'])
                ->findOrFail($matchId);

            $goals = MatchGoal::where('match_id', $matchId)
                ->with(['player', 'team'])
                ->orderBy('minute')
                ->get();

            return response()->json([
                'success' => true,
                'match' => [
                    'id' => $match->id,
                    'team1_name' => $match->teamname_1,
                    'team2_name' => $match->teamname_2,
                    'score_team1' => $match->score_team1,
                    'score_team2' => $match->score_team2,
                    'status' => $match->status,
                    'date' => $match->date,
                ],
                'goals' => $goals,
                'total_goals' => $goals->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}