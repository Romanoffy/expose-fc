<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Merchandise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat keranjang Anda.');
        }

        $cartItems = Cart::with('merchandise')
            ->where('id_user', Auth::id())
            ->get();

        return view('client.cart', compact('cartItems'));
    }

    /**
     * Tambah item ke keranjang (AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_merchandise' => 'required|exists:merchandise,id',
            'ukuran' => 'required|string',
            'warna' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu.'
            ], 401);
        }

        $merch = Merchandise::findOrFail($request->id_merchandise);

        if ($merch->stok < $request->jumlah) {
            return response()->json([
                'success' => false,
                'message' => "Stok tidak mencukupi. Tersedia: {$merch->stok}"
            ], 400);
        }

        // Cek jika item dengan varian sama sudah ada di keranjang
        $existing = Cart::where('id_user', Auth::id())
            ->where('id_merchandise', $merch->id)
            ->where('ukuran', $request->ukuran)
            ->where('warna', $request->warna)
            ->first();

        if ($existing) {
            $existing->jumlah += $request->jumlah;
            $existing->subtotal = $existing->jumlah * $existing->harga_satuan;
            $existing->save();
        } else {
            Cart::create([
                'id_user' => Auth::id(),
                'id_merchandise' => $merch->id,
                'ukuran' => $request->ukuran,
                'warna' => $request->warna,
                'jumlah' => $request->jumlah,
                'harga_satuan' => $merch->harga,
                'subtotal' => $merch->harga * $request->jumlah,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!'
        ]);
    }

    /**
     * Hapus item dari keranjang
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menghapus item.');
        }

        $cartItem = Cart::where('id_user', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang.'
        ]);
    }

    /**
     * Update jumlah item di keranjang
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id_user', Auth::id())->findOrFail($id);
        $merch = Merchandise::findOrFail($cartItem->id_merchandise);

        if ($request->jumlah > $merch->stok) {
            return response()->json([
                'success' => false,
                'message' => "Stok tidak mencukupi. Maksimal {$merch->stok} item."
            ], 400);
        }

        $cartItem->jumlah = $request->jumlah;
        $cartItem->subtotal = $cartItem->harga_satuan * $request->jumlah;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Jumlah item berhasil diperbarui.'
        ]);
    }

    /**
     * Checkout (simpan item terpilih ke session)
     */
   public function checkout(Request $request)
{
    $selectedItems = $request->input('items');
    if(!is_array($selectedItems) || empty($selectedItems)){
        return redirect()->route('cart.index')->with('error','Pilih minimal satu item untuk checkout.');
    }

    Session::put('checkout_items', $selectedItems);

    return redirect()->route('checkout.show');
}


    /**
     * Hitung jumlah item di keranjang (untuk badge AJAX)
     */
    public function count()
{
    $user = Auth::user();
    $count = $user ? Cart::where('id_user', $user->id)->count() : 0;

    return response()->json(['count' => $count]);
}

}
