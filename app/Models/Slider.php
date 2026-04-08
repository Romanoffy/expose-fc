<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    protected $table = 'slider';
    protected $guarded = [];

    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'gambar',
        'status',
    ];
}
