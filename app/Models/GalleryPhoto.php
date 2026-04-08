<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryPhoto extends Model
{
    use HasFactory;
     use SoftDeletes;

    protected $table = 'galleryphoto';

    protected $fillable = [
        'gallery_id',
        'photo',
        'alt',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }
}
