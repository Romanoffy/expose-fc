<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $fillable = [
        'id_user',
        'id_merchandise',
        'ukuran',
        'warna',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class, 'id_merchandise');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
