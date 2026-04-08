<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gallery';

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class, 'gallery_id');
    }
}
