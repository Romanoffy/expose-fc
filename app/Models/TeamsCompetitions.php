<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamsCompetitions extends Model
{
    protected $table = 'teams_competitions';
    use HasFactory;

    protected $fillable = [
        'team_id',
        'competition_id'
    ];

    /**
     * Index method untuk query dengan join
     */
    public static function index($search = '')
    {
        return TeamsCompetitions::select("teams_competitions.*", "competitions.name as competition_name", "teams.name as team_name")
            ->leftJoin('competitions', 'competitions.id', '=', 'teams_competitions.competition_id')
            ->leftJoin('teams', 'teams.id', '=', 'teams_competitions.team_id')
            ->orderBy('team_id', 'desc')
            ->when($search, function ($query, $search) {
                return $query->where('competition_id', 'like', "%" . $search . "%");
            });
    }

    /**
     * Relationship: TeamsCompetitions belongs to Competition
     */
    public function competitions(): BelongsTo
    {
        return $this->belongsTo(Competitions::class, 'competition_id');
    }

    /**
     * Relationship: TeamsCompetitions belongs to Team
     * FIXED: Gunakan singular 'team' untuk konsistensi Laravel
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }

    /**
     * DEPRECATED: Alias untuk backward compatibility
     * Gunakan team() untuk kode baru
     */
    public function teams(): BelongsTo
    {
        return $this->team();
    }
}