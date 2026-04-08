<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Illuminate\Http\Request;

class ClientTeamsController extends Controller
{
    public function index()
    {
        $teams = Teams::all();
        return view('client.teams', compact('teams'));
    }

    public function show($id)
    {
        $team = Teams::findOrFail($id);
        return view('client.detail-teams', compact('team'));
    }
}
