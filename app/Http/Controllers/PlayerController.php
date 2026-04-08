<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Teams;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Auth;

class PlayerController extends Controller
{
    public function __construct()
    {
        // $this->middleware('isadmin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 8;
        $search = $request->search ?? null;

        return view('admin.players.index', [
            'player_array' => Players::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }


    public function playersite(Request $request)
    {
        $limit = $request->limit ?? 100;
        $search = $request->search ?? null;

        return view('client.players', [
            'player_array' => Players::index($search)->paginate($limit),
            'blog_array' => Blogs::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.players.create',[
            'teams' => Teams::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $players = new Players;
        $players->team_id = $request->input('team_id');    
        $players->name = $request->input('name');
        $players->birth_date = $request->input('birth_date');
        $players->gender = $request->input('gender');
        $players->status = $request->input('status');


        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('photo')){
            $players->photo = $request->file('photo')->store('player','public');
        }

        try {
            $players->save();
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

            return redirect('admin/players')
            ->with('success', 'Player berhasil dibuat!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/players/create')
            ->with('error', 'Player belum berhasil dibuat!')->withInput();
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
        return view('admin.players.edit', [
            'player_array' => Players::find($id),
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

        $players = Players::find($id);  
        $players->team_id = $request->input('team_id');    
        $players->name = $request->input('name');
        $players->birth_date = $request->input('birth_date');
        $players->gender = $request->input('gender');
        $players->status = $request->input('status');

        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);
        
        if ($request->hasFile('photo')){
            $players->photo = $request->file('photo')->store('player','public');
        }

        try {
            $players->save();
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

            return redirect('admin/players')
            ->with('success', 'Player berhasil diedit!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/players/{{$id}}/edit')
            ->with('error', 'Player belum berhasil diedit!')->withInput();
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $players = Players::find($id);
        
        try {
            $players->delete();
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

            return redirect('admin/players')
            ->with('success', 'Player berhasil dihapus!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/players')
            ->with('error', 'Player belum berhasil dihapus!')->withInput();
        }
    }
}