<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\User;
use App\Models\Merchandise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksi.merchandise'])
            ->latest()
            ->paginate(10);

        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $users = User::all();
        $merchandise = Merchandise::all();

        return view('admin.transaksi.create', compact('users', 'merchandise'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'tanggal_transaksi' => 'required|date',
            'metode_pembayaran' => 'required|string',
            'id_merchandise' => 'required|exists:merchandise,id',
            'ukuran' => 'required|string',
            'bukti_pembayaran' => 'nullable|image|max:2048',
        ]);

        $buktiPembayaranPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        // Ambil data merchandise
        $merchandise = \App\Models\Merchandise::findOrFail($request->id_merchandise);

        // Hitung total harga
        $total = $merchandise->harga;

        $transaksi = \App\Models\Transaksi::create([
            'id_user' => $request->id_user,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_harga' => $total,
            'status' => 'pending',
            'bukti_pembayaran' => $buktiPembayaranPath,
        ]);

        // Simpan detail transaksi
        \App\Models\DetailTransaksi::create([
            'id_transaksi' => $transaksi->id,
            'id_merchandise' => $merchandise->id,
            'jumlah' => 1,
            'harga_satuan' => $merchandise->harga,
            'subtotal' => $merchandise->harga,
            'ukuran' => $request->ukuran,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.merchandise')->findOrFail($id);
        $users = User::all();
        $merchandise = Merchandise::all();

        // ✅ perbaikan disini
        return view('admin.transaksi.edit', compact('transaksi', 'users', 'merchandise'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'tanggal_transaksi' => 'required|date',
            'metode_pembayaran' => 'required|string|max:100',
            'status' => 'required|string',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update file bukti jika baru diupload
        if ($request->hasFile('bukti_pembayaran')) {
            if ($transaksi->bukti_pembayaran) {
                Storage::disk('public')->delete($transaksi->bukti_pembayaran);
            }
            $validated['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti', 'public');
        } else {
            $validated['bukti_pembayaran'] = $transaksi->bukti_pembayaran;
        }

        $transaksi->update($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->bukti_pembayaran) {
            Storage::disk('public')->delete($transaksi->bukti_pembayaran);
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
