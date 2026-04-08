<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class Pelatih extends Model
{   
    protected $table = 'pelatih'; 
    protected $guarded = [];


    use HasFactory;
}
