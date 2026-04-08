<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'link',
        'thumbnail',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all videos with optional search filter
     *
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function index($search = '')
    {
        return self::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('link', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc');
    }

    /**
     * Extract YouTube video ID from URL
     *
     * @return string|null
     */
    public function getYoutubeIdAttribute()
    {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?\/]+)/', $this->link, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Get YouTube thumbnail URL
     *
     * @param string $quality (default|mqdefault|hqdefault|sddefault|maxresdefault)
     * @return string|null
     */
    public function getYoutubeThumbnail($quality = 'hqdefault')
    {
        $videoId = $this->youtube_id;

        if (!$videoId) {
            return null;
        }

        return "https://img.youtube.com/vi/{$videoId}/{$quality}.jpg";
    }

    /**
     * Get thumbnail URL (custom or YouTube)
     *
     * @return string
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }

        return $this->getYoutubeThumbnail() ?? asset('assets/placeholder.jpg');
    }

    /**
     * Get YouTube embed URL
     *
     * @return string|null
     */
    public function getEmbedUrlAttribute()
    {
        $videoId = $this->youtube_id;

        if (!$videoId) {
            return null;
        }

        return "https://www.youtube.com/embed/{$videoId}";
    }

    /**
     * Check if video is from YouTube
     *
     * @return bool
     */
    public function isYoutubeVideo()
    {
        return !is_null($this->youtube_id);
    }

    /**
     * Scope for YouTube videos only
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYoutubeOnly($query)
    {
        return $query->where('link', 'like', '%youtube.com%')
            ->orWhere('link', 'like', '%youtu.be%');
    }

    /**
     * Scope for videos with custom thumbnails
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCustomThumbnail($query)
    {
        return $query->whereNotNull('thumbnail');
    }

    /**
     * Scope for recent videos
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}