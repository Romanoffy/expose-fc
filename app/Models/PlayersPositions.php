<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayersPositions extends Model
{
    protected $table = 'players_positions';

    use HasFactory;

    // Tambahkan relasi
    public function player()
    {
        return $this->belongsTo(Players::class, 'player_id');
    }

    public function position()
    {
        return $this->belongsTo(Positions::class, 'position_id');
    }

    public static function index($search = '')
    {
        return PlayersPositions::select(
            "players_positions.*",
            "players.name as player_name",
            "players.photo as player_photo",  // Tambahkan ini
            "positions.name as position_name"
        )
            ->leftJoin('players', 'players.id', '=', 'players_positions.player_id')
            ->leftJoin('positions', 'positions.id', '=', 'players_positions.position_id')
            ->orderBy('player_id', 'desc')
            ->when($search, function ($query, $search) {
                return $query->where('players.name', 'like', "%" . $search . "%")
                    ->orWhere('positions.name', 'like', "%" . $search . "%");
            });
    }
}