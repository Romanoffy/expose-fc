<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class NewsCategories extends Model
{
    protected $table = 'news_categories';

    use HasFactory;
    // use HasSlug;

    public static function index($search = '')
    { 
        return NewsCategories::orderBy('id','desc')
        ->when($search, function($query, $search){
            return $query->where('name','like',"%". $search . "%");
        });
    }
    public function news_category(): hasMany
    {
     return $this->hasMany(News::class, 'news_category_id');
    }
}