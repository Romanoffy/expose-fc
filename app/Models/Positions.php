<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class Positions extends Model
{
    protected $table = 'positions';
    use HasFactory;
    // use HasSlug;

    public static function index($search = '')
    { 
        return Positions::orderBy('name','asc')
        ->when($search, function($query, $search){
            return $query->where('name','like',"%". $search . "%");
        });
    }

    public function player_position()
    {
        return $this->hasManyThrough(Players::class, PlayersPositions::class, 'player_id');
    }
}