<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class Latihan extends Model
{
    protected $table = 'latihan';
    protected $guarded = [];


    use HasFactory;
}
