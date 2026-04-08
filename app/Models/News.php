<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class News extends Model
{
    protected $table = 'news';

    use HasFactory;
    // use HasSlug;

    public static function index($search = '', $status)
    {
        return News::select("news.*", "news_categories.name as category_name")
            ->leftJoin('news_categories', 'news_categories.id', '=', 'news.news_category_id')
            ->orderBy('title', 'desc')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%" . $search . "%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            });
    }

    public function news_category(): BelongsTo
    {
        return $this->belongsTo(NewsCategories::class, 'news_category_id');
    }
    public function category()
    {
        return $this->belongsTo(NewsCategories::class, 'news_category_id');
    }
    public function getStatusLabelAttribute()
    {
        return $this->status == 1 ? 'Publish' : 'Unpublish';
    }
}
