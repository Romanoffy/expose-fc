<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksi extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'detail_transaksi';
    protected $fillable = [
        'id_transaksi',
        'id_merchandise',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'ukuran',
        'warna'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class, 'id_merchandise');
    }
}
