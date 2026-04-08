<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class HistoryPesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil transaksi user + detail + merchandise
        $transaksi = Transaksi::with(['detailTransaksi.merchandise' => function ($q) {
            $q->select('id', 'nama_produk', 'gambar');
        }])
        ->where('id_user', $user->id) // ⬅️ ubah dari user_id ke id_user
        ->select('id', 'id_user', 'tanggal_transaksi', 'total_harga', 'status')
        ->orderBy('id', 'desc')
        ->get();

        return view('client.history-pesanan', compact('transaksi'));
    }
}


