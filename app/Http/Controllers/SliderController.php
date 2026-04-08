<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|string|in:Aktif,Nonaktif',
        ]);

        $path = $request->file('gambar')->store('uploads/slider', 'public');

        Slider::create([
            'gambar' => $path,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider berhasil ditambahkan.');
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
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|string|in:Aktif,Nonaktif',
        ]);

        // 🔹 Ambil data slider berdasarkan ID
        $slider = Slider::findOrFail($id);

        $data = ['status' => $request->status];

        // 🔹 Jika ada gambar baru diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($slider->gambar && Storage::disk('public')->exists($slider->gambar)) {
                Storage::disk('public')->delete($slider->gambar);
            }

            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('uploads/slider', 'public');
        }

        // 🔹 Update data slider
        $slider->update($data);

        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari slider berdasarkan ID
        $slider = Slider::findOrFail($id);

        // Hapus file gambar dari storage jika masih ada
        if ($slider->gambar && Storage::disk('public')->exists($slider->gambar)) {
            Storage::disk('public')->delete($slider->gambar);
        }

        // Hapus data slider dari database
        $slider->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}