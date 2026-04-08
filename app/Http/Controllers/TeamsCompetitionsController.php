<?php

namespace App\Http\Controllers;

use App\Models\TeamsCompetitions;
use App\Models\Teams;
use App\Models\Competitions;
use Illuminate\Http\Request;
use Auth;

class TeamsCompetitionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('isadmin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 8;
        $search = $request->search ?? null;

        return view('admin.teams_competitions.index', [
            'teams_competitions_array' => TeamsCompetitions::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teams_competitions.create',[
            'competitions' => Competitions::all(),
            'teams' => Teams::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $teamscompetitions = new TeamsCompetitions;    
        $teamscompetitions->team_id = $request->input('team_id');
        $teamscompetitions->competition_id = $request->input('competition_id');
        


        try {
            $teamscompetitions->save();
            // $formFields = $request->validate([
            //     'title' => 'required',
            //     'date' => 'required',
            //     'mini_description' => 'required',
            //     'full_description' => 'required',
            //     'writer' => 'required'
            // ]);

            // // if ($request->hasFile('images')){
            // //     $formFields['images'] = $request->file('images')->store('picture', 'public');
            // // }

            // Blogs::create($formFields);

            return redirect('admin/teams_competitions')
            ->with('success', 'Team berhasil dibuat!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/teams_competitions/create')
            ->with('error', 'Team belum berhasil dibuat!')->withInput();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.teams_competitions.edit', [
            'teams_competitions_array' => TeamsCompetitions::find($id),
            'competitions' => Competitions::all(),
            'teams' => Teams::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $teamscompetitions = TeamsCompetitions::find($id);    
        $teamscompetitions->team_id = $request->input('team_id');
        $teamscompetitions->competition_id = $request->input('competition_id');
        


        try {
            $teamscompetitions->save();
            // $formFields = $request->validate([
            //     'title' => 'required',
            //     'date' => 'required',
            //     'mini_description' => 'required',
            //     'full_description' => 'required',
            //     'writer' => 'required'
            // ]);

            // // if ($request->hasFile('images')){
            // //     $formFields['images'] = $request->file('images')->store('picture', 'public');
            // // }

            // Blogs::create($formFields);

            return redirect('admin/teams_competitions')
            ->with('success', 'Team berhasil diedit!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/teams_competitions/{{$id}}/edit')
            ->with('error', 'Team belum berhasil diedit!')->withInput();
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $teamscompetitions = TeamsCompetitions::find($id);
        
        
        try {
            $teamscompetitions->delete();
            // $formFields = $request->validate([
            //     'title' => 'required',
            //     'date' => 'required',
            //     'mini_description' => 'required',
            //     'full_description' => 'required',
            //     'writer' => 'required'
            // ]);

            // // if ($request->hasFile('images')){
            // //     $formFields['images'] = $request->file('images')->store('picture', 'public');
            // // }

            // Blogs::create($formFields);

            return redirect('admin/teams_competitions')
            ->with('success', 'Team berhasil dihapus!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/teams_competitions')
            ->with('error', 'Team belum berhasil dihapus!')->withInput();
        }
    }
}