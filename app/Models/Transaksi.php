<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = [
        'id_user',
        'tanggal_transaksi',
        'total_harga',
        'status',
        'metode_pembayaran',
        'bukti_pembayaran',
        'alamat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
