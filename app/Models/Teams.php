<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teams extends Model
{
    protected $table = 'teams';
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'descriptions'
    ];

    /**
     * Index method untuk query dengan search
     */
    public static function index($search = '')
    {
        return Teams::orderBy('name', 'asc')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%" . $search . "%");
            });
    }

    /**
     * Relationship: Team has many Matches (as Home Team)
     */
    public function matches(): HasMany
    {
        return $this->hasMany(Matches::class, 'team_id_1');
    }

    /**
     * Relationship: Team has many Matches (as Away Team)
     */
    public function matches_2(): HasMany
    {
        return $this->hasMany(Matches::class, 'team_id_2');
    }

    /**
     * Relationship: Team has many Matches (as Winner)
     */
    public function winner_teams(): HasMany
    {
        return $this->hasMany(Matches::class, 'winner_team_id');
    }

    /**
     * Relationship: Team has many Players
     */
    public function players(): HasMany
    {
        return $this->hasMany(Players::class, 'team_id');
    }

    /**
     * DEPRECATED: Alias untuk backward compatibility
     * Gunakan players() untuk kode baru
     */
    public function team_id(): HasMany
    {
        return $this->players();
    }

    /**
     * Relationship: Team belongs to many Competitions
     * Through TeamsCompetitions pivot table
     */
    public function competitions(): BelongsToMany
    {
        return $this->belongsToMany(
            Competitions::class,
            'teams_competitions',
            'team_id',
            'competition_id'
        )->withTimestamps();
    }

    /**
     * DEPRECATED: Use competitions() instead
     * Kept for backward compatibility
     */
    public function team_competition(): BelongsToMany
    {
        return $this->competitions();
    }

    /**
     * Relationship: Team has many TeamsCompetitions records
     */
    public function teamCompetitions(): HasMany
    {
        return $this->hasMany(TeamsCompetitions::class, 'team_id');
    }

    /**
     * Get all matches (home + away)
     */
    public function allMatches()
    {
        return Matches::where('team_id_1', $this->id)
            ->orWhere('team_id_2', $this->id)
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Get total matches played
     */
    public function getTotalMatchesAttribute()
    {
        return Matches::where(function ($query) {
            $query->where('team_id_1', $this->id)
                ->orWhere('team_id_2', $this->id);
        })->where('status', Matches::STATUS_FINISHED)->count();
    }

    /**
     * Get total wins
     */
    public function getTotalWinsAttribute()
    {
        return Matches::where('winner_team_id', $this->id)
            ->where('status', Matches::STATUS_FINISHED)
            ->count();
    }

    /**
     * Get total goals scored
     */
    public function getTotalGoalsAttribute()
    {
        $homeGoals = Matches::where('team_id_1', $this->id)
            ->where('status', Matches::STATUS_FINISHED)
            ->sum('score_team1');

        $awayGoals = Matches::where('team_id_2', $this->id)
            ->where('status', Matches::STATUS_FINISHED)
            ->sum('score_team2');

        return $homeGoals + $awayGoals;
    }

    /**
     * Get team logo URL
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('assets/client/images/EXPOSE FC.png'); // Default logo
    }

    /**
     * Scope: Active teams only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope: Teams in specific competition
     */
    public function scopeInCompetition($query, $competitionId)
    {
        return $query->whereHas('teamCompetitions', function ($q) use ($competitionId) {
            $q->where('competition_id', $competitionId);
        });
    }
}