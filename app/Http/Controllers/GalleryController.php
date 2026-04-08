<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with(['photos' => function ($q) {
            $q->latest();
        }])->latest()->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('thumbnail')?->store('gallery/thumbnails', 'public');

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $path,
            'status' => 'Aktif',
        ]);

        return redirect()->route('gallery.index')->with('success', 'Gallery berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $path = $gallery->thumbnail;

        // jika user upload thumbnail baru
        if ($request->hasFile('thumbnail')) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('thumbnail')->store('gallery/thumbnails', 'public');
        }

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $path,
            'status' => $request->status ?? 'Aktif',
        ]);

        return redirect()->route('gallery.index')->with('success', 'Gallery berhasil diperbarui.');
    }

    /**
     * Soft delete the specified resource.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery berhasil dipindahkan ke sampah.');
    }

    public function galleriesite(Request $request)
    {
        $limit = $request->limit ?? 9;

        $query = Gallery::with('photos')->where('status', 'Aktif');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $galleries = $query->orderBy('created_at', 'desc')->paginate($limit);

        return view('client.gallery', [
            'gallery_array' => $galleries
        ]);
    }

    /**
     * Show gallery detail (frontend)
     */
    public function gallery_detail($id_slug)
    {
        $id = explode('-', $id_slug)[0] ?? null;

        $gallery = Gallery::with('photos')->findOrFail($id);

        return view('client.detail-gallery', [
            'gallery' => $gallery
        ]);
    }
}
