<?php

namespace App\Http\Controllers;

use App\Models\Positions;
use Illuminate\Http\Request;
use Auth;

class PositionController extends Controller
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

        return view('admin.positions.index', [
            'position_array' => Positions::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $positions = new Positions;    
        $positions->name = $request->input('name');

        try {
            $positions->save();
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

            return redirect('admin/positions')
            ->with('success', 'Posisi berhasil dibuat!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/positions/create')
            ->with('error', 'Posisi belum berhasil dibuat!')->withInput();
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
        return view('admin.positions.edit', [
            'position_array' => Positions::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd(1);
        $currentUser = Auth::user();

        $positions = Positions::find($id);
        $positions->name = $request->input('name');
;

        try {
            $positions->save();
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

            return redirect('admin/positions')
            ->with('success', 'Posisi berhasil diedit!');
        }
            catch(\Throwable $th) {
                dd($th);
            return redirect('admin/positions/{{$id}}/edit')
            ->with('error', 'Posisi belum berhasil diedit!')->withInput();
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $currentUser = Auth::user();

        $positions = Positions::find($id);

        try {
            $positions->delete();
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

            return redirect('admin/positions')
            ->with('success', 'Posisi berhasil dihapus!');
        }
            catch(\Throwable $th) {
                dd($th);
            return redirect('admin/positions')
            ->with('error', 'Posisi belum berhasil dihapus!')->withInput();
        }
    }
}