@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-light">Edit Transaksi</h4>
            <p class="text-secondary mb-0">Perbarui data transaksi yang sudah ada.</p>
        </div>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card bg-dark text-light border-0 shadow-lg rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- pilih user -->
                    <div class="col-md-6">
                        <label class="form-label">Pilih User</label>
                        <select name="id_user" class="form-select" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $transaksi->id_user == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- tanggal transaksi -->
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" value="{{ $transaksi->tanggal_transaksi }}" class="form-control" required>
                    </div>

                    <!-- total harga -->
                    <div class="col-md-6">
                        <label class="form-label">Total Harga</label>
                        <input type="number" name="total_harga" value="{{ $transaksi->total_harga }}" class="form-control" required>
                    </div>

                    <!-- metode pembayaran -->
                    <div class="col-md-6">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="Transfer Bank" {{ $transaksi->metode_pembayaran == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="COD" {{ $transaksi->metode_pembayaran == 'COD' ? 'selected' : '' }}>COD</option>
                            <option value="E-Wallet" {{ $transaksi->metode_pembayaran == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                    </div>

                    <!-- ukuran -->
                    <div class="col-md-6">
                        <label class="form-label">Ukuran</label>
                        <select name="ukuran" class="form-select" required>
                            <option value="S" {{ $transaksi->detailTransaksi->first()->ukuran == 'S' ? 'selected' : '' }}>S</option>
                            <option value="M" {{ $transaksi->detailTransaksi->first()->ukuran == 'M' ? 'selected' : '' }}>M</option>
                            <option value="L" {{ $transaksi->detailTransaksi->first()->ukuran == 'L' ? 'selected' : '' }}>L</option>
                            <option value="XL" {{ $transaksi->detailTransaksi->first()->ukuran == 'XL' ? 'selected' : '' }}>XL</option>
                            <option value="XXL" {{ $transaksi->detailTransaksi->first()->ukuran == 'XXL' ? 'selected' : '' }}>XXL</option>
                        </select>
                    </div>

                    <!-- status -->
                    <div class="col-md-6">
                        <label class="form-label">Status Transaksi</label>
                        <select name="status" class="form-select" required>
                            <option value="Menunggu Konfirmasi" {{ $transaksi->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="confirmed" {{ $transaksi->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $transaksi->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="success" {{ $transaksi->status == 'success' ? 'selected' : '' }}>Success</option>
                            <option value="failed" {{ $transaksi->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="canceled" {{ $transaksi->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>

                    <!-- bukti pembayaran -->
                    <div class="col-md-6">
                        <label class="form-label">Bukti Pembayaran (Opsional)</label>
                        @if($transaksi->bukti_pembayaran)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $transaksi->bukti_pembayaran) }}" width="120" class="rounded shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-2"></i> Perbarui Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
