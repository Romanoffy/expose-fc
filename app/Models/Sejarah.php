<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class Sejarah extends Model
{   
    protected $table = 'sejarah'; 
    protected $guarded = [];


    use HasFactory;
}
