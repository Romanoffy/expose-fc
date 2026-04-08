<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelatih;
use Auth;

class PelatihController extends Controller
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
    $limit = $request->limit ?? 8;

    return view('admin.pelatih.index', [
        'pelatih_array' => Pelatih::paginate($limit),
        'limit' => $limit,
    ]);
}


    public function pelatihsite(Request $request)
    {
        $pelatih_array = Pelatih::all();
        return view('client.pelatih')
            ->with('pelatih_array', $pelatih_array);
    }

    public function indexAdmin()
    {
        $pelatih_array = Pelatih::all();
        return view('admin.pelatih.index')
            ->with('pelatih_array', $pelatih_array);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelatih.create', [
            'pelatih' => Pelatih::all(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        // dd($request->all());



        $pelatih = new Pelatih;
        $pelatih->nama_pelatih = $request->input('nama_pelatih');
        $pelatih->email = $request->input('email');
        $pelatih->pengalaman = $request->input('pengalaman');
        $pelatih->lisensi = $request->input('lisensi');


        if ($request->hasFile('file_lisensi')) {
            $pelatih->file_lisensi = $request->file('file_lisensi')->store('pelatih', 'public');
        }

        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('gambar')) {
            $pelatih->gambar = $request->file('gambar')->store('pelatih', 'public');
        }


        try {
            $pelatih->save();
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

            return redirect('admin/pelatih')
                ->with('success', 'Player berhasil dibuat!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/pelatih/create')
                ->with('error', 'Player belum berhasil dibuat!')->withInput();
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelatih = Pelatih::find($id);
        return $pelatih;
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        return view('admin.pelatih.edit', [
            'pelatih_array' => Pelatih::find($id)
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $pelatih = Pelatih::find($id);
        $pelatih->nama_pelatih = $request->input('nama_pelatih');
        $pelatih->email = $request->input('email');
        $pelatih->pengalaman = $request->input('pengalaman');
        $pelatih->lisensi = $request->input('lisensi');


        if ($request->hasFile('file_lisensi')) {
            $pelatih->file_lisensi = $request->file('file_lisensi')->store('pelatih', 'public');
        }

        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('gambar')) {
            $pelatih->gambar = $request->file('gambar')->store('pelatih', 'public');
        }

        try {
            $pelatih->save();
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

            return redirect('admin/pelatih')
                ->with('success', 'Pelatih berhasil diedit!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/pelatih/{{$id}}/edit')
                ->with('error', 'Pelatih belum berhasil diedit!')->withInput();
        }


    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $pelatih = Pelatih::find($id);

        try {
            $pelatih->delete();
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

            return redirect('admin/pelatih')
                ->with('success', 'Pelatih berhasil dihapus!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/pelatih')
                ->with('error', 'Pelatih belum berhasil dihapus!')->withInput();
        }
    }

}
