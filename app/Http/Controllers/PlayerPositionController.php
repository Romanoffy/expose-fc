<?php

namespace App\Http\Controllers;

use App\Models\PlayersPositions;
use App\Models\Players;
use App\Models\Positions;
use Illuminate\Http\Request;
use Auth;

class PlayerPositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('isadmin');
    }

    public function index(Request $request)
    {
        $limit = $request->limit ?? 8;
        $search = $request->search ?? null;

        return view('admin.players_positions.index', [
            'players_positions_array' => PlayersPositions::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('admin.players_positions.create', [
            'players' => Players::all(),
            'positions' => Positions::all()
        ]);
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();

        $playerspositions = new PlayersPositions;
        $playerspositions->player_id = $request->input('player_id');
        $playerspositions->position_id = $request->input('position_id');

        try {
            $playerspositions->save();

            return redirect('admin/players_positions')
                ->with('success', 'Posisi pemain berhasil dibuat!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/players_positions/create')
                ->with('error', 'Posisi pemain gagal dibuat!')->withInput();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $playerPosition = PlayersPositions::select(
            "players_positions.*",
            "players.name as player_name",
            "players.photo as player_photo",  // Pastikan ini ada
            "positions.name as position_name"
        )
            ->leftJoin('players', 'players.id', '=', 'players_positions.player_id')
            ->leftJoin('positions', 'positions.id', '=', 'players_positions.position_id')
            ->where('players_positions.id', $id)
            ->first();

        return view('admin.players_positions.edit', [
            'players_positions_array' => $playerPosition,
            'players' => Players::all(),
            'positions' => Positions::all()
        ]);
    }

    public function update(Request $request, string $id)
    {
        $currentUser = Auth::user();

        $playerspositions = PlayersPositions::find($id);
        $playerspositions->player_id = $request->input('player_id');
        $playerspositions->position_id = $request->input('position_id');

        try {
            $playerspositions->save();

            return redirect('admin/players_positions')
                ->with('success', 'Posisi pemain berhasil diperbarui!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/players_positions/' . $id . '/edit')
                ->with('error', 'Posisi pemain gagal diperbarui!')->withInput();
        }
    }

    public function destroy(string $id)
    {
        $currentUser = Auth::user();

        $playerspositions = PlayersPositions::find($id);

        try {
            $playerspositions->delete();

            return redirect('admin/players_positions')
                ->with('success', 'Posisi pemain berhasil dihapus!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/players_positions')
                ->with('error', 'Posisi pemain gagal dihapus!')->withInput();
        }
    }
}