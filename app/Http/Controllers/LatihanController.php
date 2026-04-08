<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Latihan;
use App\Models\Pelatih;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class LatihanController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?? 8;

        $latihan_array = DB::table('pelatih')
            ->join('latihan', 'pelatih.id', '=', 'latihan.id_pelatih')
            ->select('latihan.*', 'pelatih.nama_pelatih', 'pelatih.gambar')
            ->paginate($limit);

        return view('admin.latihan.index', [
            'latihan_array' => $latihan_array,
            'limit' => $limit,
        ]);
    }


    public function indexAdmin()
    {
        $latihan_array = DB::table('pelatih')
            ->join('latihan', 'pelatih.id', '=', 'latihan.id_pelatih')
            ->select('latihan.*', 'pelatih.nama_pelatih', 'pelatih.gambar')
            ->get();

        return view('admin.latihan.index')
            ->with('latihan_array', $latihan_array);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelatih_array = Pelatih::all();

        return view('admin.latihan.create')
            ->with([
                'pelatih_array' => $pelatih_array,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());


        $latihan = new Latihan;
        $latihan->id_pelatih = $request->input('id_pelatih');
        $latihan->kegiatan_latihan = $request->input('kegiatan_latihan');
        $latihan->jam_mulai_berlatih = $request->input('jam_mulai_berlatih');
        $latihan->jam_selesai_berlatih = $request->input('jam_selesai_berlatih');
        $latihan->catatan = $request->input('catatan');




        try {
            $latihan->save();
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

            return redirect('admin/latihan')
                ->with('success', 'Player berhasil dibuat!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/latihan/create')
                ->with('error', 'Player belum berhasil dibuat!')->withInput();
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
        return view('admin.latihan.edit', [
            'latihan' => Latihan::find($id),
            'pelatih_array' => Pelatih::all()


        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $latihan = Latihan::find($id);
        $latihan->id_pelatih = $request->input('id_pelatih');
        $latihan->kegiatan_latihan = $request->input('kegiatan_latihan');
        $latihan->jam_mulai_berlatih = $request->input('jam_mulai_berlatih');
        $latihan->jam_selesai_berlatih = $request->input('jam_selesai_berlatih');
        $latihan->catatan = $request->input('catatan');

        try {
            $latihan->save();
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

            return redirect('admin/latihan')
                ->with('success', 'Latihan berhasil diedit!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/latihan/{{$id}}/edit')
                ->with('error', 'Latihan belum berhasil diedit!')->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $currentUser = Auth::user();

        $latihan = Latihan::find($id);

        try {
            $latihan->delete();
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

            return redirect('admin/latihan')
                ->with('success', 'Latihan berhasil dihapus!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/latihan')
                ->with('error', 'Latihan belum berhasil dihapus!')->withInput();
        }
    }
}
