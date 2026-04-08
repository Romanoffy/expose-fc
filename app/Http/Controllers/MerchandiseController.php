<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Illuminate\Http\Request;
use Auth;

class MerchandiseController extends Controller
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
        {   
            $merchandise_array = Merchandise::all();
            return view ('admin.merchandise.index') 
            ->with('merchandise_array', $merchandise_array);
        }
    }

    public function merchandisesite(Request $request)
    {
        // $limit = $request->limit ?? 10;
        // $search = $request->search ?? null;

        // return view('client.merchandise', [
        //     'merchandise_array' => Merchandise::all($search)->paginate($limit),
        //     'limit' => $limit,
        //     'search' => $search
        // ]);
        
        $merchandise_array = Merchandise::all();
        return view ('client.merchandise') 
        ->with('merchandise_array', $merchandise_array);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.merchandise.create',[
            'merchandise' => Merchandise::all(),
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $merchandise = new Merchandise;
        $merchandise->nama_produk = $request->input('nama_produk');
        $merchandise->deskripsi = $request->input('deskripsi');
        $merchandise->harga = $request->input('harga');
        $merchandise->stok = $request->input('stok');
        $merchandise->ukuran = $request->input('ukuran');
        $merchandise->warna = $request->input('warna');
        // $merchandise->gambar = $request->input('gambar');


        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('gambar')){
            $merchandise->gambar = $request->file('gambar')->store('merchandise','public');
        }
        
        try {
        $merchandise->save();
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

            return redirect('admin/merchandise')
            ->with('success', 'Merchandise berhasil dibuat!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/merchandise/create')
            ->with('error', 'Merchandise belum berhasil dibuat!')->withInput();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $latihan = Latihan::find($id); 
        return $latihan;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        // dd($id);
        return view('admin.merchandise.edit', [
            'merchandise' => Merchandise::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $merchandise = Merchandise::find($id); 
        $merchandise->nama_produk = $request->input('nama_produk');
        $merchandise->deskripsi = $request->input('deskripsi');
        $merchandise->harga = $request->input('harga');
        $merchandise->stok = $request->input('stok');
        $merchandise->ukuran = $request->input('ukuran');
        $merchandise->warna = $request->input('warna');
        // $merchandise->gambar = $request->input('gambar');

        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('gambar')){
            $merchandise->gambar = $request->file('gambar')->store('merchandise','public');
        }
        
        try {
        $merchandise->save();
            // $formFields = $request->validate([
            //     'title' => 'required',
            //     'date' => 'required',
            //     'mini_description' => 'required',
            //     'full_description' => 'required',
            //     'writer' => 'required'
            // ]);

            if ($request->hasFile('images')){
                // $formFields['images'] = $request->file('images')->store('picture', 'public');
            }

            // Blogs::create($formFields);

            return redirect('admin/merchandise')
            ->with('success', 'Merchandise berhasil diedit!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/merchandise/{{$id}}/edit')
            ->with('error', 'Merchandise belum berhasil diedit!')->withInput();
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $merchandise = Merchandise::find($id);
        
        try {
            $merchandise->delete();
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

            return redirect('admin/merchandise')
            ->with('success', 'Merchandise berhasil dihapus!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/merchandise')
            ->with('error', 'Merchandise belum berhasil dihapus!')->withInput();
        }
    }
}