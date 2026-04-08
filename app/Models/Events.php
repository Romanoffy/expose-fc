<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Venues;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class Events extends Model
{
    protected $table = 'events';

    use HasFactory;
    // use HasSlug;

    public static function index($search = '')
    { 
        return Events::select("events.*","venues.name as venue_name")
        ->leftJoin('venues', 'venues.id', '=', 'events.venue_id')
        ->orderBy('tanggal_mulai','desc')
        ->when($search, function($query, $search){
            return $query->where('tanggal_mulai','like',"%". $search . "%");
        });
    }

    public function venue(): BelongsTo
    {
     return $this->belongsTo(Venues::class, 'venue_id');
    }
}