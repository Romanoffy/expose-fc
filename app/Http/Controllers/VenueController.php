<?php

namespace App\Http\Controllers;

use App\Models\Venues;
use Illuminate\Http\Request;
use Auth;

class VenueController extends Controller
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

        return view('admin.venues.index', [
            'venue_array' => Venues::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.venues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $venues = new Venues;   
        $venues->name = $request->input('name');
        $venues->address = $request->input('address');
        $venues->kota = $request->input('kota');
        $venues->provinsi = $request->input('provinsi');
        $venues->negara = $request->input('negara');
        $venues->contact = $request->input('contact');

        try {
            $venues->save();
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

            return redirect('admin/venues')
            ->with('success', 'Venue berhasil dibuat!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/venues/create')
            ->with('error', 'Venue belum berhasil dibuat!')->withInput();
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
        return view('admin.venues.edit', [
            'venue_array' => Venues::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $venues = Venues::find($id);   
        $venues->name = $request->input('name');
        $venues->address = $request->input('address');
        $venues->kota = $request->input('kota');
        $venues->provinsi = $request->input('provinsi');
        $venues->negara = $request->input('negara');
        $venues->contact = $request->input('contact');

        try {
            $venues->save();
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

            return redirect('admin/venues')
            ->with('success', 'Venue berhasil diedit!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/venues/{{$id}}/edit')
            ->with('error', 'Venue belum berhasil diedit!')->withInput();
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $venues = Venues::find($id);
        
        try {
            $venues->delete();
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

            return redirect('admin/venues')
            ->with('success', 'Venue berhasil dihapus!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/venues')
            ->with('error', 'Venue belum berhasil dihapus!')->withInput();
        }
    }
}