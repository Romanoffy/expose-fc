<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchGoal extends Model
{
    use HasFactory;

    protected $table = 'match_goals';

    protected $fillable = [
        'match_id',
        'player_id',
        'team_id',
        'minute',
        'goal_type'
    ];

    /**
     * Get the match
     */
    public function match()
    {
        return $this->belongsTo(Matches::class, 'match_id');
    }

    /**
     * Get the player
     */
    public function player()
    {
        return $this->belongsTo(Players::class, 'player_id');
    }

    /**
     * Get the team
     */
    public function team()
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }
}