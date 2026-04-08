<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class Contacts extends Model
{
    protected $table = 'contacts';

    use HasFactory;
    // use HasSlug;

    public static function index($search = '')
    { 
        return Contacts::orderBy('name','desc')
        ->when($search, function($query, $search){
            return $query->where('email','like',"%". $search . "%");
        });
    }
}