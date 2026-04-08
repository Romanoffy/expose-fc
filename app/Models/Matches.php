<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Matches extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'competition_id',
        'team_id_1',
        'team_id_2',
        'teamname_1',
        'teamname_2',
        'team_logo_1',
        'team_logo_2',
        'score_team1',
        'score_team2',
        'winner_team_id',
        'date',
        'venue_id',
        'link_ticket',
        'status',
    ];

    protected $casts = [
        'date' => 'datetime',
        'score_team1' => 'integer',
        'score_team2' => 'integer',
        'status' => 'integer',
    ];

    // Status constants
    const STATUS_SCHEDULED = 0;  // Jadwal pertandingan
    const STATUS_LIVE = 1;        // Sedang berlangsung
    const STATUS_FINISHED = 2;    // Selesai

    /**
     * Method untuk update status otomatis berdasarkan waktu
     */
    public static function updateMatchStatuses()
    {
        $now = Carbon::now('Asia/Jakarta');

        // Update status menjadi LIVE jika waktu pertandingan sudah dimulai
        // Asumsi pertandingan berlangsung 90 menit + 15 menit waktu tambahan = 105 menit
        self::where('status', self::STATUS_SCHEDULED)
            ->where('date', '<=', $now)
            ->update(['status' => self::STATUS_LIVE]);

        // Update status menjadi FINISHED jika pertandingan sudah lewat 105 menit
        self::where('status', self::STATUS_LIVE)
            ->where('date', '<=', $now->copy()->subMinutes(105))
            ->update(['status' => self::STATUS_FINISHED]);

        return true;
    }

    /**
     * Scope untuk index dengan search dan relasi
     * PENTING: Include 'competitions.category' agar bisa mengakses kategori di view
     */
    public static function index($search = null)
    {
        return self::query()
            ->select(
                'matches.*',
                'competitions.id as competition_id',
                'competitions.name as competition_name',
                'competitions.category as category',
                'competitions.event_type as event_type',
                't1.name as team_name_home',
                't2.name as team_name_away',
                'winner.name as winner_team_name',
                'venues.name as venue_name'
            )
            ->leftJoin('competitions', 'matches.competition_id', '=', 'competitions.id')
            ->leftJoin('teams as t1', 'matches.team_id_1', '=', 't1.id')
            ->leftJoin('teams as t2', 'matches.team_id_2', '=', 't2.id')
            ->leftJoin('teams as winner', 'matches.winner_team_id', '=', 'winner.id')
            ->leftJoin('venues', 'matches.venue_id', '=', 'venues.id')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('competitions.name', 'like', "%{$search}%")
                        ->orWhere('t1.name', 'like', "%{$search}%")
                        ->orWhere('t2.name', 'like', "%{$search}%")
                        ->orWhere('venues.name', 'like', "%{$search}%");
                });
            })
            ->with(['goals']);
            // ->orderBy('matches.date', 'desc');
    }

    /**
     * Relationship with Competition
     */
    public function competition()
    {
        return $this->belongsTo(Competitions::class, 'competition_id');
    }

    /**
     * Relationship with Team 1 (Home)
     */
    public function team1()
    {
        return $this->belongsTo(Teams::class, 'team_id_1');
    }

    /**
     * Relationship with Team 2 (Away)
     */
    public function team2()
    {
        return $this->belongsTo(Teams::class, 'team_id_2');
    }

    /**
     * Relationship with Winner Team
     */
    public function winner()
    {
        return $this->belongsTo(Teams::class, 'winner_team_id');
    }

    /**
     * Relationship with Venue
     */
    public function venue()
    {
        return $this->belongsTo(Venues::class, 'venue_id');
    }

    /**
     * Relationship with Match Goals
     */
    public function goals()
    {
        return $this->hasMany(MatchGoal::class, 'match_id');
    }

    /**
     * Get calculated score from goals (Team 1)
     */
    public function getCalculatedScoreTeam1Attribute()
    {
        $regularGoals = $this->goals()
            ->where('team_id', $this->team_id_1)
            ->where('goal_type', '!=', 'own_goal')
            ->count();

        $ownGoalsFromTeam2 = $this->goals()
            ->where('team_id', $this->team_id_2)
            ->where('goal_type', 'own_goal')
            ->count();

        return $regularGoals + $ownGoalsFromTeam2;
    }

    /**
     * Get calculated score from goals (Team 2)
     */
    public function getCalculatedScoreTeam2Attribute()
    {
        $regularGoals = $this->goals()
            ->where('team_id', $this->team_id_2)
            ->where('goal_type', '!=', 'own_goal')
            ->count();

        $ownGoalsFromTeam1 = $this->goals()
            ->where('team_id', $this->team_id_1)
            ->where('goal_type', 'own_goal')
            ->count();

        return $regularGoals + $ownGoalsFromTeam1;
    }

    /**
     * Check if scores match with goals
     */
    public function scoresMatchGoals()
    {
        return $this->score_team1 == $this->calculated_score_team1
            && $this->score_team2 == $this->calculated_score_team2;
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_SCHEDULED => 'Dijadwalkan',
            self::STATUS_LIVE => 'Sedang Berlangsung',
            self::STATUS_FINISHED => 'Selesai',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get category color
     */
    public function getCategoryColorAttribute()
    {
        return match ($this->category ?? 'internal') {
            'internal' => '#007bff',
            'external' => '#f59e0b',
            'friendly' => '#10b981',
            default => '#6b7280'
        };
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute()
    {
        return match ($this->category ?? 'internal') {
            'internal' => 'Internal',
            'external' => 'External',
            'friendly' => 'Friendly Match',
            default => 'Unknown'
        };
    }
}