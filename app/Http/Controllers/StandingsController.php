<?php

namespace App\Http\Controllers;

use App\Models\Standings;
use App\Models\Competitions;
use App\Models\Matches;
use App\Models\Teams;
use App\Models\TeamsCompetitions;
use Illuminate\Http\Request;
use Auth;

use PhpOffice\PhpSpreadsheet\IOFactory;

class StandingsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('isadmin');
    }

    /**
     * Display a listing of the resource (Admin Panel)
     */
    public function index(Request $request)
    {
        return view('admin.standings.index', [
            'standing_array' => Standings::index(),
        ]);
    }

    /**
     * Display all standings for public (Client Side)
     */
    public function allStandings(Request $request)
    {
        $year = $request->year ?? 'all';
        $category = $request->category ?? 'all';
        $event = $request->event ?? 'all';

        // Get all competitions with filters
        $query = Competitions::query();

        // Apply filters
        if ($year !== 'all') {
            $query->where('year', $year);
        }

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        if ($event !== 'all') {
            $query->where('event_type', $event);
        }

        // ✅ PRIORITY SORTING: Latest competition first
        // 1. Sort by tanggal_mulai (newest first) if available
        // 2. Then by year (newest first)
        // 3. Then by created_at (newest first)
        $competitions = $query
            ->orderByRaw('COALESCE(tanggal_mulai, created_at) DESC')
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get unique years
        $years = Competitions::selectRaw('DISTINCT year')
            ->whereNotNull('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Get all unique event types
        $events = Competitions::select('event_type')
            ->distinct()
            ->orderBy('event_type')
            ->pluck('event_type');

        return view('client.all-standings', [
            'competitions' => $competitions,
            'years' => $years,
            'events' => $events,
            'selectedYear' => $year,
            'selectedCategory' => $category,
            'selectedEvent' => $event
        ]);
    }

    /**
     * Filter standings via AJAX
     */
    public function filterStandings(Request $request)
    {
        try {
            $year = $request->input('year', 'all');
            $category = $request->input('category', 'all');
            $event = $request->input('event', 'all');

            // Get competitions with filters
            $query = Competitions::query();

            if ($year !== 'all') {
                $query->where('year', $year);
            }

            if ($category !== 'all') {
                $query->where('category', $category);
            }

            if ($event !== 'all') {
                $query->where('event_type', $event);
            }

            // ✅ PRIORITY SORTING: Latest competition first
            $competitions = $query
                ->orderByRaw('COALESCE(tanggal_mulai, created_at) DESC')
                ->orderBy('year', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            // Generate HTML content
            $html = '';

            if ($competitions->count() > 0) {
                foreach ($competitions as $competition) {
                    // Get teams from teams_competitions first
                    $teamIds = TeamsCompetitions::where('competition_id', $competition->id)
                        ->pluck('team_id')
                        ->unique();

                    // Fallback: Get from matches if no teams in teams_competitions
                    if ($teamIds->isEmpty()) {
                        $teamIds = Matches::where('competition_id', $competition->id)
                            ->whereIn('status', [Matches::STATUS_SCHEDULED, Matches::STATUS_FINISHED])
                            ->get()
                            ->flatMap(function ($match) {
                                return [$match->team_id_1, $match->team_id_2];
                            })
                            ->unique()
                            ->values();
                    }

                    $standings = $this->calculateStandings($competition->id, $teamIds);

                    $categoryColor = match ($competition->category ?? 'internal') {
                        'internal' => '#007bff',
                        'external' => '#f59e0b',
                        'friendly' => '#10b981',
                        default => '#6b7280',
                    };

                    $html .= $this->renderStandingsCard($competition, $standings, $categoryColor);
                }
            } else {
                $html .= $this->renderEmptyState();
            }

            return response()->json([
                'success' => true,
                'html' => $html
            ]);

        } catch (\Exception $e) {
            \Log::error('Filter Standings Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'html' => '<div class="alert alert-danger" style="margin: 20px; padding: 20px; background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; border-radius: 8px; color: #ef4444;"><p style="margin: 0;"><strong>Error loading standings:</strong> ' . $e->getMessage() . '</p></div>'
            ], 500);
        }
    }

    /**
     * Calculate standings for a competition
     */
    private function calculateStandings($competitionId, $teamIds)
    {
        $standings = [];

        foreach ($teamIds as $teamId) {
            $team = Teams::find($teamId);
            if (!$team) {
                continue;
            }

            // Get only FINISHED matches
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
                'points' => 0,
            ];

            foreach ($matches as $match) {
                $isHome = $match->team_id_1 == $teamId;
                $teamScore = $isHome ? $match->score_team1 : $match->score_team2;
                $opponentScore = $isHome ? $match->score_team2 : $match->score_team1;

                $stats['goals_for'] += $teamScore ?? 0;
                $stats['goals_against'] += $opponentScore ?? 0;

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

        return $standings;
    }

    /**
     * Render standings card HTML
     */
    private function renderStandingsCard($competition, $standings, $categoryColor)
    {
        $categoryLabel = strtoupper($competition->category ?? 'INTERNAL');

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
                $statusBadge = '<span class="status-badge-active"><i class="fas fa-circle"></i> ONGOING</span>';
            } elseif ($now->lt($startDate)) {
                $isUpcoming = true;
                $statusBadge = '<span class="status-badge-upcoming"><i class="far fa-clock"></i> UPCOMING</span>';
            }
        }

        $html = '<div class="standings-card-wrapper">';
        $html .= '<div class="standings-card' . ($isActive ? ' card-active' : '') . ($isUpcoming ? ' card-upcoming' : '') . '">';

        // Header
        $html .= '<div class="standings-card-header" style="border-color: ' . $categoryColor . '">';
        $html .= '<h3 class="standings-card-title">';
        $html .= '<i class="fas fa-trophy"></i> Klasemen ' . htmlspecialchars($competition->name) . ' - ' . htmlspecialchars($competition->year);
        $html .= '</h3>';
        $html .= '<div class="standings-card-badges">';

        // Status badge (Active/Upcoming)
        if ($statusBadge) {
            $html .= $statusBadge;
        }

        $html .= '<span class="competition-badge-card" style="background: ' . $categoryColor . '">' . $categoryLabel . '</span>';
        $html .= '<span class="event-badge-card">' . htmlspecialchars($competition->event_type ?? 'Event') . '</span>';
        $html .= '</div></div>';

        if (count($standings) > 0) {
            // Table
            $html .= '<div class="standings-card-table-wrapper">';
            $html .= '<table class="standings-card-table"><thead><tr>';
            $html .= '<th>#</th><th>Team</th><th>MP</th><th>W</th><th>D</th><th>L</th>';
            $html .= '<th>GF</th><th>GA</th><th>GD</th><th>PTS</th>';
            $html .= '</tr></thead><tbody>';

            foreach ($standings as $index => $standing) {
                $html .= '<tr>';
                $html .= '<td class="position-cell-card">';

                if ($index == 0) {
                    $html .= '<span class="qualification-badge-card qual-champion-card"></span>';
                } elseif ($index < 4) {
                    $html .= '<span class="qualification-badge-card qual-playoff-card"></span>';
                }

                $html .= ($index + 1) . '</td>';

                // Team cell
                $html .= '<td><div class="team-cell-card">';
                if ($standing->team->logo) {
                    $html .= '<img src="' . asset('storage/' . $standing->team->logo) . '" alt="' . htmlspecialchars($standing->team->name) . '" class="team-logo-small-card">';
                } else {
                    $html .= '<div class="team-logo-placeholder-card">' . strtoupper(substr($standing->team->name, 0, 1)) . '</div>';
                }
                $html .= '<span class="team-name-card">' . htmlspecialchars($standing->team->name);
                if ($index == 0 && $standing->points > 0) {
                    $html .= '<span class="champion-badge-card">TOP</span>';
                }
                $html .= '</span></div></td>';

                // Stats
                $html .= '<td>' . $standing->matches_played . '</td>';
                $html .= '<td>' . $standing->wins . '</td>';
                $html .= '<td>' . $standing->draws . '</td>';
                $html .= '<td>' . $standing->losses . '</td>';
                $html .= '<td>' . $standing->goals_for . '</td>';
                $html .= '<td>' . $standing->goals_against . '</td>';

                $gdColor = $standing->goal_difference >= 0 ? '#10b981' : '#ef4444';
                $gdPrefix = $standing->goal_difference > 0 ? '+' : '';
                $html .= '<td class="goal-diff-card" style="color: ' . $gdColor . '">' . $gdPrefix . $standing->goal_difference . '</td>';
                $html .= '<td class="points-cell-card">' . $standing->points . '</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody></table></div>';

            // Legend
            $html .= '<div class="standings-card-legend">';
            $html .= '<div class="legend-items">';
            $html .= '<div class="legend-item"><span class="qualification-badge-card qual-champion-card"></span><span>Champion Position</span></div>';
            $html .= '<div class="legend-item"><span class="qualification-badge-card qual-playoff-card"></span><span>Playoff Position</span></div>';
            $html .= '</div>';
            $html .= '<div class="legend-abbr">MP: Matches Played | W: Wins | D: Draws | L: Losses | GF: Goals For | GA: Goals Against | GD: Goal Difference | PTS: Points</div>';
            $html .= '</div>';
        } else {
            // Empty state
            $html .= '<div class="empty-state-card">';
            $html .= '<i class="fas fa-info-circle"></i>';
            $html .= '<h4>Klasemen Masih Kosong</h4>';
            $html .= '<p>Belum ada tim yang terdaftar untuk kompetisi ini. Silakan tambahkan tim terlebih dahulu.</p>';
            $html .= '</div>';
        }

        $html .= '</div></div>';

        return $html;
    }

    /**
     * Render empty state HTML
     */
    private function renderEmptyState()
    {
        return '<div class="no-competitions-state">' .
            '<i class="fas fa-trophy"></i>' .
            '<h3>Tidak Ada Kompetisi Ditemukan</h3>' .
            '<p>Coba sesuaikan filter Anda atau tidak ada kompetisi yang cocok dengan kriteria.</p>' .
            '<a href="/standings" class="btn-back-home">' .
            '<i class="fas fa-redo"></i> Reset Filter' .
            '</a>' .
            '</div>';
    }
    /**
     * Get API standings for specific competition
     */
    public function getCompetitionStandings($competitionId)
    {
        $competition = Competitions::find($competitionId);

        if (!$competition) {
            return response()->json([
                'success' => false,
                'message' => 'Competition not found'
            ], 404);
        }

        $teamIds = Matches::where('competition_id', $competitionId)
            ->whereIn('status', [Matches::STATUS_SCHEDULED, Matches::STATUS_FINISHED])
            ->get()
            ->flatMap(function ($match) {
                return [$match->team_id_1, $match->team_id_2];
            })
            ->unique()
            ->values();

        if ($teamIds->isEmpty()) {
            $teamIds = TeamsCompetitions::where('competition_id', $competitionId)
                ->pluck('team_id')
                ->unique();
        }

        $standings = $this->calculateStandings($competitionId, $teamIds);

        return response()->json([
            'success' => true,
            'competition' => $competition,
            'standings' => $standings
        ]);
    }

    /**
     * Store a newly created resource in storage (Admin - Excel Upload)
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|mimes:xlsx,csv',
            ]);

            $uploadedFile = $request->file('file');
            $uploadedFilePath = $uploadedFile->getPathname();
            $spreadsheet = IOFactory::load($uploadedFilePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $filename = 'standings.xlsx';
            $path = storage_path('app/public/standings/' . $filename);

            if (file_exists($path)) {
                $existingSpreadsheet = IOFactory::load($path);
                $existingWorksheet = $existingSpreadsheet->getActiveSheet();
            }

            $highestRow = $existingWorksheet->getHighestRow();
            if ($highestRow > 1) {
                $existingWorksheet->removeRow(2, $highestRow - 1);
            }

            $headerRow = $worksheet->getRowIterator(1)->current();
            $headerCells = $headerRow->getCellIterator();
            $headerCells->setIterateOnlyExistingCells(false);

            $headerData = [];
            foreach ($headerCells as $cell) {
                $headerData[] = $cell->getValue();
            }
            $existingWorksheet->fromArray($headerData, null, 'A1');

            $rowIndex = 2;
            foreach ($worksheet->getRowIterator() as $row) {
                if ($row->getRowIndex() == 1) {
                    continue;
                }

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    if ($cell->isFormula()) {
                        $rowData[] = $cell->getCalculatedValue();
                    } else {
                        $rowData[] = $cell->getValue();
                    }
                }

                $existingWorksheet->fromArray($rowData, null, 'A' . $rowIndex, true);
                $rowIndex++;
            }

            $writer = IOFactory::createWriter($existingSpreadsheet, 'Xlsx');
            $writer->save($path);

            Standings::truncate();
            foreach ($worksheet->getRowIterator() as $row) {
                if ($row->getRowIndex() == 1) {
                    continue;
                }

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    if ($cell->isFormula()) {
                        $rowData[] = $cell->getCalculatedValue();
                    } else {
                        $rowData[] = $cell->getValue();
                    }
                }

                Standings::create([
                    'team_id' => $rowData[0],
                    'win' => $rowData[1],
                    'draw' => $rowData[2],
                    'lose' => $rowData[3],
                    'goal_for' => $rowData[4],
                    'goal_against' => $rowData[5],
                    'goal_difference' => $rowData[6],
                    'point' => $rowData[7],
                ]);
            }

            return redirect('admin/standings')
                ->with('success', 'Klasemen berhasil diupdate!');
        }

        return redirect('admin/standings')
            ->with('error', 'Klasemen belum berhasil diupdate!')->withInput();
    }

    public function download_template()
    {
        $filename = 'standings.xlsx';
        $path = storage_path('app/public/standings/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        // 
    }

    public function update(Request $request, string $id)
    {
        // dd($request->all());
    }

    public function destroy(string $id)
    {
        // dd($request->all());
    }
}