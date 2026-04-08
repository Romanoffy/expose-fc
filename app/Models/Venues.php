<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class Venues extends Model
{
    protected $table = 'venues';

    use HasFactory;
    // use HasSlug;

    public static function index($search = '')
    { 
        return Venues::orderBy('name','asc')
        ->when($search, function($query, $search){
            return $query->where('kota','like',"%". $search . "%");
        });
    }
    public function events(): hasMany
    {
     return $this->hasMany(Events::class, 'venue_id');
    }

    public function matches(): hasMany
    {
     return $this->hasMany(Matches::class, 'venue_id');
    }
}