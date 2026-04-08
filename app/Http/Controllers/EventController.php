<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Venues;
use Illuminate\Http\Request;
use Auth;

class EventController extends Controller
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

        return view('admin.events.index', [
            'event_array' => Events::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create',[
            'venues' => Venues::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $events = new Events;    
        $events->nama = $request->input('nama');
        $events->description = $request->input('description');
        $events->tanggal_mulai = $request->input('tanggal_mulai');
        $events->tanggal_selesai = $request->input('tanggal_selesai');
        $events->venue_id = $request->input('venue_id');
        
        try {
            $events->save();
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

            return redirect('admin/events')
            ->with('success', 'Event berhasil dibuat!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/events/create')
            ->with('error', 'Event belum berhasil dibuat!')->withInput();
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
        return view('admin.events.edit', [
            'event_array' => Events::find($id),
            'venues' => Venues::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $events = Events::find($id);   
        $events->nama = $request->input('nama');
        $events->description = $request->input('description');
        $events->tanggal_mulai = $request->input('tanggal_mulai');
        $events->tanggal_selesai = $request->input('tanggal_selesai');
        $events->venue_id = $request->input('venue_id');

        try {
            $events->save();
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

            return redirect('admin/events')
            ->with('success', 'Event berhasil diedit!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/events/{{$id}}/edit')
            ->with('error', 'Event belum berhasil diedit!')->withInput();
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $events = Events::find($id);
        
        try {
            $events->delete();
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

            return redirect('admin/events')
            ->with('success', 'Event berhasil dihapus!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/events')
            ->with('error', 'Event belum berhasil dihapus!')->withInput();
        }
    }
}