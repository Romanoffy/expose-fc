<?php

namespace App\Http\Controllers;

use App\Models\Sejarah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class SejarahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // $this->middleware('isadmin');
    }
    
    public function index(Request $request)
{
    $limit = $request->limit ?? 8; // default 10 item per halaman

    // Ambil semua sejarah dengan paginate
    $sejarah_array = Sejarah::orderBy('id', 'desc')->paginate($limit);

    return view('admin.sejarah.index', [
        'sejarah_array' => $sejarah_array,
        'limit' => $limit,
    ]);
}


    public function sejarahsite(Request $request)
    {
        $sejarah_array = Sejarah::all();
        return view ('client.sejarah') 
        ->with('sejarah_array', $sejarah_array);
    }

    public function indexAdmin(){
        $sejarah_array = Sejarah::all();
        return view ('admin.sejarah.index') 
        ->with('sejarah_array', $sejarah_array);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sejarah.create',[
            'sejarah' => Sejarah::all(),
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    

    public function store(Request $request)
    {
        // dd($request->all());
        


        $sejarah = new Sejarah();
        $sejarah->judul = $request->input('judul');    
        $sejarah->sub_judul = $request->input('sub_judul');


        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('gambar')){
            $sejarah->gambar = $request->file('gambar')->store('sejarah','public');
        }


        try {
            $sejarah->save();
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

            return redirect('admin/sejarah')
            ->with('success', 'Trophy berhasil dibuat!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/sejarah/create')
            ->with('error', 'Trophy belum berhasil dibuat!')->withInput();
        }
    }

    

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sejarah = Sejarah::find($id); 
        return $sejarah;
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        return view('admin.sejarah.edit', [
            'sejarah_array' => Sejarah::find($id)
        ]);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $sejarah = Sejarah::find($id);  
        $sejarah->judul = $request->input('judul');    
        $sejarah->sub_judul = $request->input('sub_judul');

        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('gambar')){
            $sejarah->gambar = $request->file('gambar')->store('sejarah','public');
        }
        
        try {
            $sejarah->save();
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

            return redirect('admin/sejarah')
            ->with('success', 'Trophy berhasil diedit!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/sejarah/{{$id}}/edit')
            ->with('error', 'Trophy belum berhasil diedit!')->withInput();
        }

        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $sejarah = Sejarah::find($id);
        
        try {
            $sejarah->delete();
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

            return redirect('admin/sejarah')
            ->with('success', 'Trophy berhasil dihapus!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/sejarah')
            ->with('error', 'Trophy belum berhasil dihapus!')->withInput();
        }
    }

}
