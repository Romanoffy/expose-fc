<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Merchandise;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     * Bisa dari cart (multi-item) atau direct buy
     */
    public function show(Request $request)
    {
        $items = collect();
        $totalHarga = 0;
        $user = Auth::user();

        // 1. Checkout dari cart (multi-item)
        if ($request->has('items')) {
            $cartIds = $request->input('items');
            $cartItems = Cart::with('merchandise')
                ->whereIn('id', $cartIds)
                ->where('id_user', $user->id)
                ->get();

            foreach ($cartItems as $cart) {
                if (!$cart->merchandise) continue;

                $item = (object) [
                    'id_cart' => $cart->id,
                    'id_merchandise' => $cart->id_merchandise,
                    'merchandise' => $cart->merchandise,
                    'jumlah' => $cart->jumlah,
                    'ukuran' => $cart->ukuran ?? '-',
                    'warna' => $cart->warna ?? '-',
                    'harga_satuan' => $cart->harga_satuan,
                    'subtotal' => $cart->subtotal,
                ];

                $items->push($item);
                $totalHarga += $item->subtotal;
            }
        }
        // 2. Direct buy
        elseif ($request->has(['id_merchandise', 'jumlah'])) {
            $request->validate([
                'id_merchandise' => 'required|exists:merchandise,id',
                'jumlah' => 'required|integer|min:1',
                'ukuran' => 'nullable|string',
                'warna' => 'nullable|string',
            ]);

            $merchandise = Merchandise::findOrFail($request->id_merchandise);

            $item = (object) [
                'id_merchandise' => $merchandise->id,
                'merchandise' => $merchandise,
                'jumlah' => (int) $request->jumlah,
                'ukuran' => $request->ukuran ?? '-',
                'warna' => $request->warna ?? '-',
                'harga_satuan' => $merchandise->harga,
                'subtotal' => $merchandise->harga * (int) $request->jumlah,
            ];

            $items->push($item);
            $totalHarga = $item->subtotal;
        }
        // Tidak ada item
        else {
            return redirect()->route('cart.index')
                ->with('error', 'Belum ada item untuk checkout.');
        }

        return view('checkout.show', compact('items', 'totalHarga'));
    }

    /**
     * Proses checkout
     */
    public function complete(Request $request)
    {
        $user = Auth::user();

        // Jika checkout dari cart (multi-item)
        if ($request->has('items')) {
            $request->validate([
                'items' => 'required|array|min:1',
                'alamat' => 'required|string|max:255',
                'metode_pembayaran' => 'required|string',
                'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            return DB::transaction(function () use ($request, $user) {

                $cartItems = Cart::with('merchandise')
                    ->whereIn('id', $request->items)
                    ->where('id_user', $user->id)
                    ->get();

                if ($cartItems->isEmpty()) {
                    throw new \Exception("Item checkout tidak ditemukan.");
                }

                $totalHarga = 0;

                // Simpan bukti pembayaran jika ada
                $buktiPembayaranPath = null;
                if ($request->hasFile('bukti_pembayaran')) {
                    $buktiPembayaranPath = $request->file('bukti_pembayaran')
                        ->store('bukti_pembayaran', 'public');
                }

                // Buat transaksi utama
                $transaksi = Transaksi::create([
                    'id_user' => $user->id,
                    'tanggal_transaksi' => now(),
                    'total_harga' => 0, // sementara, akan diupdate nanti
                    'alamat' => $request->alamat,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'bukti_pembayaran' => $buktiPembayaranPath,
                    'status' => 'Menunggu Konfirmasi',
                ]);

                // Loop tiap item, cek stok, buat detail, kurangi stok, hapus cart
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->merchandise;
                    if (!$product) continue;

                    if ($cartItem->jumlah > $product->stok) {
                        throw new \Exception("Stok tidak cukup untuk " . $product->nama_produk);
                    }

                    $product->stok -= $cartItem->jumlah;
                    $product->save();

                    $subtotal = $cartItem->jumlah * $product->harga;
                    $totalHarga += $subtotal;

                    DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id,
                        'id_merchandise' => $product->id,
                        'jumlah' => $cartItem->jumlah,
                        'harga_satuan' => $product->harga,
                        'subtotal' => $subtotal,
                        'ukuran' => $cartItem->ukuran,
                        'warna' => $cartItem->warna,
                    ]);

                    // Hapus item dari cart setelah sukses
                    $cartItem->delete();
                }

                // Update total harga transaksi
                $transaksi->total_harga = $totalHarga;
                $transaksi->save();

                return redirect()->route('checkout.success', ['id' => $transaksi->id])
                    ->with('success', 'Checkout berhasil!');
            }, 5);
        }

        // Jika direct buy
        else {
            $request->validate([
                'id_merchandise' => 'required|exists:merchandise,id',
                'jumlah' => 'required|integer|min:1',
                'ukuran' => 'nullable|string',
                'warna' => 'nullable|string',
                'alamat' => 'required|string|max:255',
                'metode_pembayaran' => 'required|string',
                'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            return DB::transaction(function () use ($request, $user) {
                $product = Merchandise::findOrFail($request->id_merchandise);

                if ($request->jumlah > $product->stok) {
                    throw new \Exception("Stok tidak cukup untuk " . $product->nama_produk);
                }

                // Kurangi stok
                $product->stok -= $request->jumlah;
                $product->save();

                $subtotal = $request->jumlah * $product->harga;

                // Simpan bukti pembayaran jika ada
                $buktiPembayaranPath = null;
                if ($request->hasFile('bukti_pembayaran')) {
                    $buktiPembayaranPath = $request->file('bukti_pembayaran')
                        ->store('bukti_pembayaran', 'public');
                }

                $transaksi = Transaksi::create([
                    'id_user' => $user->id,
                    'tanggal_transaksi' => now(),
                    'total_harga' => $subtotal,
                    'alamat' => $request->alamat,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'bukti_pembayaran' => $buktiPembayaranPath,
                    'status' => 'Menunggu Konfirmasi',
                ]);

                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_merchandise' => $product->id,
                    'jumlah' => $request->jumlah,
                    'harga_satuan' => $product->harga,
                    'subtotal' => $subtotal,
                    'ukuran' => $request->ukuran ?? '-',
                    'warna' => $request->warna ?? '-',
                ]);

                return redirect()->route('checkout.success', ['id' => $transaksi->id])
                    ->with('success', 'Checkout berhasil!');
            }, 5);
        }
    }

    /**
     * Halaman sukses checkout
     */
    public function success($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.merchandise')->findOrFail($id);
        return view('checkout.success', compact('transaksi'));
    }
}
