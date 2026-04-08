<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Videos;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncYouTubeVideos extends Command
{
    protected $signature = 'youtube:sync';
    protected $description = 'Sync latest videos from YouTube channel';

    public function handle()
    {
        try {
            $apiKey = env('YOUTUBE_API_KEY');
            $channelId = env('YOUTUBE_CHANNEL_ID');

            if (!$apiKey || !$channelId) {
                $this->error('YouTube API Key atau Channel ID belum dikonfigurasi!');
                return 1;
            }

            $maxVideos = 10; // atau ambil dari opsi jika mau fleksibel
            $syncCount = 0;
            $pageToken = null;
            $totalFetched = 0;

            do {
                $perPage = min(50, $maxVideos - $totalFetched);
                if ($perPage <= 0)
                    break;

                $params = [
                    'part' => 'snippet',
                    'channelId' => $channelId,
                    'maxResults' => $perPage,
                    'order' => 'date',
                    'type' => 'video',
                    'key' => $apiKey,
                ];

                if ($pageToken) {
                    $params['pageToken'] = $pageToken;
                }

                // 🔥 Perbaiki URL: HAPUS SPASI DI AKHIR!
                $response = Http::get('https://www.googleapis.com/youtube/v3/search', $params);

                if ($response->failed()) {
                    $this->error('Gagal mengambil data dari YouTube API!');
                    return 1;
                }

                $data = $response->json();
                $videos = $data['items'] ?? [];
                $pageToken = $data['nextPageToken'] ?? null;

                foreach ($videos as $video) {
                    $videoId = $video['id']['videoId'] ?? null;
                    if (!$videoId)
                        continue;

                    $link = "https://www.youtube.com/watch?v={$videoId}";

                    // Cek apakah sudah ada
                    if (Videos::where('link', $link)->exists()) {
                        continue;
                    }

                    Videos::create([
                        'title' => $video['snippet']['title'] ?? 'Untitled',
                        'link' => $link,
                        'description' => $video['snippet']['description'] ?? null,
                        'youtube_id' => $videoId,
                        'thumbnail' => null,
                    ]);

                    $syncCount++;
                }

                $totalFetched += count($videos);
            } while ($pageToken && $totalFetched < $maxVideos);

            if ($syncCount === 0) {
                $this->info("Tidak ada video baru untuk di-sync.");
            } else {
                $this->info("Berhasil sync {$syncCount} video baru!");
            }

            return 0;

        } catch (\Exception $e) {
            $this->error('Sync gagal: ' . $e->getMessage());
            return 1;
        }
    }
}