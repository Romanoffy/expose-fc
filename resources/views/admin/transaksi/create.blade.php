@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-light">Tambah Transaksi</h4>
            <p class="text-secondary mb-0">Buat transaksi baru untuk pembelian merchandise.</p>
        </div>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card bg-dark text-light border-0 shadow-lg rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <!-- pilih user -->
                    <div class="col-md-6">
                        <label class="form-label">Pilih User</label>
                        <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- tanggal transaksi -->
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" required>
                        @error('tanggal_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- metode pembayaran -->
                    <div class="col-md-6">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="COD">COD (Bayar di Tempat)</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                        @error('metode_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- merchandise -->
                    <div class="col-md-6">
                        <label class="form-label">Pilih Merchandise</label>
                        <select name="id_merchandise" class="form-select @error('id_merchandise') is-invalid @enderror" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($merchandise as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_produk }} - Rp{{ number_format($item->harga, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        @error('id_merchandise')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ukuran -->
                    <div class="col-md-6">
                        <label class="form-label">Ukuran</label>
                        <select name="ukuran" class="form-select @error('ukuran') is-invalid @enderror" required>
                            <option value="">-- Pilih Ukuran --</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                        @error('ukuran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- bukti pembayaran -->
                    <div class="col-md-12">
                        <label class="form-label">Bukti Pembayaran (Opsional)</label>
                        <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept="image/*">
                        @error('bukti_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
