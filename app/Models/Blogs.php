<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;


class Blogs extends Model
{
    protected $table = 'blogs';
    use HasFactory;
    // use HasSlug;

    public static function index($search = '')
    { 
        return Blogs::orderBy('date','desc')
        ->when($search, function($query, $search){
            return $query->where('title','like',"%". $search . "%");
        });
    }

    

}
