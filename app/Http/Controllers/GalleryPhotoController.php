<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryPhotoController extends Controller
{
    /**
     * Simpan foto baru ke galeri (via modal di halaman gallery.index)
     */
    public function store(Request $request, $galleryId)
    {
        $gallery = Gallery::findOrFail($galleryId);

        $request->validate([
            'photo' => 'required|image|max:4096',
        ]);

        $path = $request->file('photo')->store('gallery/photos', 'public');

        GalleryPhoto::create([
            'gallery_id' => $gallery->id,
            'photo' => $path,
            'status' => 'Aktif',
        ]);

        return redirect()->route('gallery.index')
            ->with('success', 'Foto berhasil ditambahkan.');
    }

    /**
     * Update foto (misalnya ubah status atau ganti gambar)
     */
    public function update(Request $request, $galleryId, $photoId)
    {
        $photo = GalleryPhoto::findOrFail($photoId);

        $request->validate([
            'photo' => 'nullable|image|max:4096',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $path = $photo->photo;

        // Jika ada foto baru di-upload
        if ($request->hasFile('photo')) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('photo')->store('gallery/photos', 'public');
        }

        $photo->update([
            'photo' => $path,
            'status' => $request->status,
        ]);

        return redirect()->route('gallery.index')
            ->with('success', 'Foto berhasil diperbarui.');
    }

    /**
     * Soft delete foto
     */
    public function destroy($galleryId, $photoId)
    {
        $photo = GalleryPhoto::findOrFail($photoId);
        $photo->delete();

        return redirect()->route('gallery.index')
            ->with('success', 'Foto berhasil dihapus.');
    }
}
