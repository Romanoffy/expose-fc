<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $search = $request->search ?? null;

        $query = Videos::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        return view('admin.videos.index', [
            'video_array' => $query->orderBy('created_at', 'desc')->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'link' => 'required|url',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            ]);

            $video = new Videos();
            $video->title = $validated['title'];
            $video->link = $validated['link'];

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $video->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
            } else {
                // Auto-fetch YouTube thumbnail if no custom thumbnail
                $videoId = $this->extractYouTubeId($validated['link']);
                if ($videoId) {
                    // YouTube thumbnail URL (no need to store, just use direct link)
                    // Or you can download and store it
                    $video->thumbnail = null; // We'll use YouTube thumbnail directly in view
                }
            }

            $video->save();

            return redirect('/admin/videos')
                ->with('success', 'Video berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect('/admin/videos/create')
                ->with('error', 'Video gagal ditambahkan! ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = Videos::findOrFail($id);
        return view('admin.videos.edit', [
            'video_array' => $video
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $video = Videos::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'link' => 'required|url',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            ]);

            $video->title = $validated['title'];
            $video->link = $validated['link'];

            // Handle new thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($video->thumbnail) {
                    Storage::disk('public')->delete($video->thumbnail);
                }
                $video->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            $video->save();

            return redirect('/admin/videos')
                ->with('success', 'Video berhasil diupdate!');
        } catch (\Throwable $th) {
            return redirect('/admin/videos/' . $id . '/edit')
                ->with('error', 'Video gagal diupdate! ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $video = Videos::findOrFail($id);

            // Delete thumbnail if exists
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }

            $video->delete();

            // Handle AJAX request
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Video berhasil dihapus!'
                ]);
            }

            return redirect('/admin/videos')
                ->with('success', 'Video berhasil dihapus!');
        } catch (\Throwable $th) {
            // Handle AJAX request
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video gagal dihapus! ' . $th->getMessage()
                ], 500);
            }

            return redirect('/admin/videos')
                ->with('error', 'Video gagal dihapus! ' . $th->getMessage());
        }
    }

    /**
     * Delete multiple videos
     */
    public function deleteMultiple(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:videos,id'
            ]);

            $ids = $request->ids;

            // Get videos before deletion to handle thumbnails
            $videos = Videos::whereIn('id', $ids)->get();

            $deletedCount = 0;

            foreach ($videos as $video) {
                // Delete thumbnail if exists
                if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                    Storage::disk('public')->delete($video->thumbnail);
                }

                // Delete video
                if ($video->delete()) {
                    $deletedCount++;
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$deletedCount} video berhasil dihapus"
                ]);
            }

            return redirect()->route('videos.index')
                ->with('success', "{$deletedCount} video berhasil dihapus");

        } catch (\Exception $e) {
            Log::error('Error deleting multiple videos: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus video: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('videos.index')
                ->with('error', 'Terjadi kesalahan saat menghapus video');
        }
    }

    /**
     * Sync videos from YouTube Channel with pagination support
     */
    public function syncYouTube(Request $request)
    {
        try {
            $apiKey = env('YOUTUBE_API_KEY');
            $channelId = env('YOUTUBE_CHANNEL_ID');

            // Validasi input max_videos
            $request->validate([
                'max_videos' => 'required|integer|in:10,25,50'
            ]);

            $maxVideos = $request->input('max_videos', 10);

            if (!$apiKey || !$channelId) {
                return redirect('/admin/videos')
                    ->with('error', 'YouTube API Key atau Channel ID belum dikonfigurasi!');
            }

            $syncCount = 0;
            $pageToken = null;
            $totalFetched = 0;

            // Loop untuk pagination (jika ingin lebih dari 50 video)
            do {
                // YouTube API max 50 per request
                $perPage = min(50, $maxVideos - $totalFetched);

                if ($perPage <= 0)
                    break;

                $params = [
                    'part' => 'snippet',
                    'channelId' => $channelId,
                    'maxResults' => $perPage,
                    'order' => 'date',
                    'type' => 'video',
                    'key' => $apiKey
                ];

                // Tambahkan pageToken jika ada (untuk halaman selanjutnya)
                if ($pageToken) {
                    $params['pageToken'] = $pageToken;
                }

                $response = Http::get('https://www.googleapis.com/youtube/v3/search', $params);

                if ($response->failed()) {
                    return redirect('/admin/videos')
                        ->with('error', 'Gagal mengambil data dari YouTube API!');
                }

                $data = $response->json();
                $videos = $data['items'] ?? [];
                $pageToken = $data['nextPageToken'] ?? null;

                foreach ($videos as $video) {
                    $videoId = $video['id']['videoId'] ?? null;
                    $title = $video['snippet']['title'] ?? 'Untitled';
                    $description = $video['snippet']['description'] ?? null;
                    $link = "https://www.youtube.com/watch?v={$videoId}";

                    // Check if video already exists
                    $exists = Videos::where('link', $link)->exists();

                    if (!$exists && $videoId) {
                        Videos::create([
                            'title' => $title,
                            'link' => $link,
                            'thumbnail' => null, // Use YouTube thumbnail
                            'description' => $description,
                            'youtube_id' => $videoId,
                        ]);
                        $syncCount++;
                    }
                }

                $totalFetched += count($videos);

            } while ($pageToken && $totalFetched < $maxVideos);

            $message = "Berhasil sync {$syncCount} video baru dari {$maxVideos} video terbaru YouTube!";

            if ($syncCount === 0) {
                $message = "Tidak ada video baru untuk di-sync dari {$maxVideos} video terbaru. Semua video sudah ada di database.";
            }

            return redirect('/admin/videos')
                ->with('success', $message);

        } catch (\Throwable $th) {
            return redirect('/admin/videos')
                ->with('error', 'Sync gagal! ' . $th->getMessage());
        }
    }

    /**
     * Extract YouTube video ID from URL
     */
    private function extractYouTubeId($url)
    {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?\/]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Get YouTube thumbnail URL
     */
    public function getYouTubeThumbnail($videoId)
    {
        // Gunakan thumbnail kualitas maksimal
        return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";

        // Alternatif lain:
        // hqdefault.jpg (320x180)
        // mqdefault.jpg (480x360)
        // sddefault.jpg (640x480)
    }

     public function videosite(Request $request)
    {
        $limit = $request->limit ?? 9; // videos per page

        $query = Videos::query();

        // Optional search by title
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $videos = $query->orderBy('created_at', 'desc')->paginate($limit);

        return view('client.videos', [
            'video_array' => $videos,
        ]);
    }

     public function video_detail($id_slug)
    {
        // $id_slug format: {id}-{slug}
        $id = explode('-', $id_slug)[0] ?? null;

        $video = Videos::findOrFail($id);

        return view('client.detail-videos', [
            'video' => $video
        ]);
    }
}