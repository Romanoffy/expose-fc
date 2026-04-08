<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Illuminate\Http\Request;
use Auth;

class TeamsController extends Controller
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

        return view('admin.teams.index', [
            'team_array' => Teams::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $teams = new Teams;    
        $teams->name = $request->input('name');
        $teams->descriptions = $request->input('descriptions');
        

        // Validate the request to ensure 'logo' is an image
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);
    
        if ($request->hasFile('logo')){
            $teams->logo = $request->file('logo')->store('team','public');
        }

        try {
            $teams->save();
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

            return redirect('admin/teams')
            ->with('success', 'Team berhasil dibuat!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/teams/create')
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
        return view('admin.teams.edit', [
            'team_array' => Teams::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $teams = Teams::find($id);   
        $teams->name = $request->input('name');
        $teams->descriptions = $request->input('descriptions');
        
        // Validate the request to ensure 'logo' is an image
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);
        
        if ($request->hasFile('logo')){
            $teams->logo = $request->file('logo')->store('team','public');
        }

        try {
            $teams->save();
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

            return redirect('admin/teams')
            ->with('success', 'Team berhasil diedit!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/teams/{{$id}}/edit')
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

        $teams = Teams::find($id);
        
        try {
            $teams->delete();
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

            return redirect('admin/teams')
            ->with('success', 'Team berhasil dihapus!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/teams')
            ->with('error', 'Team belum berhasil dihapus!')->withInput();
        }
    }
}